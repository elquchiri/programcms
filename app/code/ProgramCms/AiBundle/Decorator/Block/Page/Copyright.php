<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AiBundle\Decorator\Block\Page;

use Exception;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;

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
    protected \ProgramCms\AdminBundle\Block\Page\Copyright $subject;
    const PROGRAMCMS_BIRTHDAY = 2022;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        #[MapDecorated] \ProgramCms\AdminBundle\Block\Page\Copyright $subject,
        array $data = []
    )
    {
        $this->subject = $subject;
        parent::__construct($context, $data);
    }

    /**
     * After Decorator
     * @return string
     * @throws Exception
     */
    public function toHtml(): string
    {
        $copyRightHtmlOutput = $this->_toHtml();
        if(($yearsOfExistence = $this->subject->getCopyrightYear() - self::PROGRAMCMS_BIRTHDAY) >= 1) {
            $copyRightHtmlOutput .= sprintf("<p class=\"mt-1\" style=\"font-size: 11px; font-weight: bold;\">%s Year%s Of Existence, by <a href=\"mailto: elquchiri@gmail.com\">Med E.</a></p>", $yearsOfExistence, $yearsOfExistence > 1 ? "s" : "");
        }

        return $copyRightHtmlOutput;
    }
}