<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

use HttpResponseException;
use ProgramCms\ConfigBundle\App\Config;
use ProgramCms\CoreBundle\App\AreaList;
use ProgramCms\CoreBundle\App\State;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Controller
 * @package ProgramCms\CoreBundle\Controller
 */
abstract class Controller extends AbstractController
{
    /**
     * @var State
     */
    protected State $_state;

    /**
     * @var AreaList
     */
    protected AreaList $_areaList;

    /**
     * @var LocaleSwitcher
     */
    protected LocaleSwitcher $localeSwitcher;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Controller constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
    )
    {
        parent::__construct($context);
        $this->_areaList = $context->getAreaList();
        $this->_state = $context->getState();
        $this->localeSwitcher = $context->getLocaleSwitcher();
        $this->security = $context->getSecurity();
        $this->translator = $context->getTranslator();
        $this->config = $context->getConfig();
    }

    /**
     * Dispatch Request
     * @return mixed
     * @throws HttpResponseException
     */
    public function dispatch(): mixed
    {
        // Set website view locale
        $this->localeSwitcher->setLocale($this->_state->getLocale());

        $areaCode = $this->_areaList->getCodeByFrontName($this->getRequest()->getFrontName());
        $this->_state->setAreaCode($areaCode);
        $result = $this->execute();
        if($result instanceof \ProgramCms\CoreBundle\View\Result\Page) {
            try {
                return $result->render();
            } catch (\Exception $e) {
                dd($e->getMessage());
                // TODO: Log errors instead of printing
                var_dump($e->getTraceAsString());
            }
        }
        else if($result instanceof \Symfony\Component\HttpFoundation\RedirectResponse) {
            return $result;
        }

        throw new HttpResponseException("Unexpected Result instance.");
    }

    /**
     * Helper for translate inside Controller classes
     * @param string $message
     * @return string
     */
    public function trans(string $message): string
    {
        return $this->translator->trans($message);
    }
}