<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AiBundle\Decorator\Block\Page;

use Exception;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Copyright AI Decorator
 * @package ProgramCms\AiBundle\Decorator\Block\Page
 */
#[AsDecorator(
    decorates: \ProgramCms\AdminBundle\Block\Page\Copyright::class,
    priority: 1
)]
class Copyright extends \ProgramCms\AdminBundle\Block\Page\Copyright
{
    /**
     * @var \ProgramCms\AdminBundle\Block\Page\Copyright
     */
    protected \ProgramCms\AdminBundle\Block\Page\Copyright $subject;

    /**
     * ProgramCMS's BirthYear
     */
    const PROGRAMCMS_BIRTHDAY = 2022;

    /**
     * Copyright constructor.
     * @param Context $context
     * @param TranslatorInterface $translator
     * @param \ProgramCms\AdminBundle\Block\Page\Copyright $subject
     * @param array $data
     */
    public function __construct(
        Context $context,
        TranslatorInterface $translator,
        #[MapDecorated] \ProgramCms\AdminBundle\Block\Page\Copyright $subject,
        array $data = []
    )
    {
        $this->subject = $subject;
        parent::__construct($context, $translator, $data);
    }

    /**
     * After Decorator
     * @return string
     * @throws Exception
     */
    public function toHtml(): string
    {
        $copyRightHtmlOutput = $this->subject->toHtml();
        if(($yearsOfExistence = $this->subject->getCopyrightYear() - self::PROGRAMCMS_BIRTHDAY) >= 1) {
            $copyRightHtmlOutput .= sprintf(
                "<p class=\"mt-1\" style=\"font-size: 10px;\">".
                $this->trans("Designed & Maintained by") .
                "<a href=\"mailto: elquchiri@gmail.com\"> ".
                $this->trans("Mohamed EL QUCHIRI").
                "</a>" .
                "</p>", $yearsOfExistence);
        }

        return $copyRightHtmlOutput;
    }
}