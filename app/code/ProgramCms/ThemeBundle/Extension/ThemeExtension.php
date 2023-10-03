<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Extension;

use ProgramCms\CoreBundle\View\Layout;

/**
 * Class ThemeExtension
 * @package ProgramCms\ThemeBundle\Extension
 */
class ThemeExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * @var Layout
     */
    protected Layout $layout;

    /**
     * ThemeExtension constructor.
     * @param Layout $layout
     */
    public function __construct(
        Layout $layout
    )
    {
        $this->layout = $layout;
    }

    /**
     * Accessing Layout from ThemeExtension
     * @return Layout
     */
    public function getLayout(): Layout
    {
        return $this->layout;
    }

    /**
     * Defines All Twig Token Parsers
     * @return array
     */
    public function getTokenParsers()
    {
        return [
            new \ProgramCms\ThemeBundle\Parser\PageTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\UpdateTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\LayoutTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\TitleTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\ContainerTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\BlockTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\Argument\ArgumentsTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\Argument\ArgumentTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\ReferenceBlockTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\CssTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\JsTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\MoveTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\ReferenceContainerTokenParser()
        ];
    }
}