<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AiBundle\Decorator\Block\Page;

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
     */
//    public function toHtml(): string
//    {
//        $copyRightHtmlOutput = $this->subject->toHtml();
//        $programCmsBirthday = 2022;
//        if(($yearsOfExistence = $this->subject->getCopyrightYear() - $programCmsBirthday) >= 1) {
//            $copyRightHtmlOutput .= sprintf("<p>%s %s</p>", $yearsOfExistence, "Years Of Existence");
//        }
//
//        return $copyRightHtmlOutput;
//    }
}