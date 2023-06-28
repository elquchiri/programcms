<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Extension;

/**
 * Class ThemeExtension
 * @package ProgramCms\ThemeBundle\Extension
 */
class ThemeExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * @var \ProgramCms\CoreBundle\View\Layout
     */
    protected \ProgramCms\CoreBundle\View\Layout $layout;

    public function __construct(
        \ProgramCms\CoreBundle\View\Layout $layout
    )
    {
        $this->layout = $layout;
    }

    /**
     * @return \ProgramCms\CoreBundle\View\Layout
     */
    public function getLayout(): \ProgramCms\CoreBundle\View\Layout
    {
        return $this->layout;
    }

    /**
     * Defines All ProgramCms's Twig Token Parsers
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