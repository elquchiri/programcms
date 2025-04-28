<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Mailer\Template;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\Mailer\Config\TemplateConfigBuilder;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\MailBundle\Repository\EmailTemplateRepository;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use ReflectionException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Translation\LocaleSwitcher;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;

/**
 * Class TransportBuilder
 * @package ProgramCms\CoreBundle\Mailer\Template
 */
class TransportBuilder implements TransportBuilderInterface
{
    const LOCALE_CONFIG = 'general/locale_options/locale';

    /**
     * @var MailerInterface
     */
    protected MailerInterface $mailer;

    /**
     * @var string
     */
    protected string $templateId;

    /**
     * @var array
     */
    protected array $templateOptions;

    /**
     * @var array
     */
    protected array $templateVars = [];

    /**
     * @var string
     */
    protected string $from;

    /**
     * @var array
     */
    protected array $to;

    /**
     * @var int
     */
    protected int $priority;

    /**
     * @var string
     */
    protected string $subject;

    /**
     * @var string
     */
    protected string $text = '';

    /**
     * @var TemplateConfigBuilder
     */
    protected TemplateConfigBuilder $templateConfigBuilder;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var LocaleSwitcher
     */
    protected LocaleSwitcher $localeSwitcher;

    /**
     * @var Config
     */
    protected Config $config;
    protected EmailTemplateRepository $emailTemplateRepository;

    /**
     * TransportBuilder constructor.
     * @param ObjectManager $objectManager
     * @param MailerInterface $mailer
     * @param TemplateConfigBuilder $templateConfigBuilder
     * @param LocaleSwitcher $localeSwitcher
     * @param Config $config
     */
    public function __construct(
        ObjectManager $objectManager,
        MailerInterface $mailer,
        TemplateConfigBuilder $templateConfigBuilder,
        LocaleSwitcher $localeSwitcher,
        Config $config,
        EmailTemplateRepository $emailTemplateRepository
    )
    {
        $this->mailer = $mailer;
        $this->priority = Email::PRIORITY_NORMAL;
        $this->templateConfigBuilder = $templateConfigBuilder;
        $this->objectManager = $objectManager;
        $this->localeSwitcher = $localeSwitcher;
        $this->config = $config;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setTemplateId($id): static
    {
        $this->templateId = $id;
        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setTemplateOptions(array $options = []): static
    {
        $this->templateOptions = $options;
        return $this;
    }

    /**
     * @param array $vars
     * @return $this
     */
    public function setTemplateVars(array $vars): static
    {
        $this->templateVars = $vars;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setFrom(string $email): static
    {
        $this->from = $email;
        return $this;
    }

    /**
     * @param array $to
     * @return $this
     */
    public function setTo(array $to): static
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param int $priority
     * @return $this
     */
    public function setPriority(int $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Send Email Message
     * @throws TransportExceptionInterface
     */
    public function sendMessage()
    {
        try {
            $emailTemplate = $this->runTemplate();
            $emailObject = (new Email())
                ->from($this->from)
                ->to(implode(',', $this->to))
                ->priority($this->priority)
                ->subject($this->subject)
                ->text(empty($this->text) ? $emailTemplate : $this->text)
                ->html($emailTemplate);
            // Send Recovery Token Email
            $this->mailer->send($emailObject);
        } catch (ReflectionException | SyntaxError | LoaderError $e) {
            // Log errors
            var_dump($e);
        }
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function prepareTemplate(): string
    {
        $templateObject = $this->emailTemplateRepository->getByCode($this->templateId);
        if($templateObject) {
            return '<style>' . $templateObject->getCss() . '</style>' .  $templateObject->getHtml();
        }

        /** @var Template $template */
        $template = $this->objectManager->create(Template::class);
        $templatePath = $this->templateConfigBuilder->getTemplate($this->templateId);
        $area = $this->templateConfigBuilder->getArea($this->templateId);
        return $template
            ->setTemplate($templatePath)
            ->setArea($area)
            ->assign(['block' => $template])
            ->assign($this->templateVars)
            ->toHtml();
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function runTemplate(): string
    {
        if(isset($this->templateOptions['website_view'])) {
            /** @var WebsiteView $websiteView */
            $websiteView = $this->templateOptions['website_view'];
            $locale = $this->config->getValue(
                self::LOCALE_CONFIG,
                ScopeInterface::SCOPE_WEBSITE_VIEW,
                $websiteView->getWebsiteViewId()
            );
            $this->localeSwitcher->runWithLocale($locale, function () {
                return $this->prepareTemplate();
            });
        }
        return $this->prepareTemplate();
    }
}