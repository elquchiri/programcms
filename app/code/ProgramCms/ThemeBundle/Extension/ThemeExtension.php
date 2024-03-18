<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Extension;

use ProgramCms\CoreBundle\View\Layout;
use ProgramCms\ThemeBundle\Parser\Argument\ArgumentsTokenParser;
use ProgramCms\ThemeBundle\Parser\Argument\ArgumentTokenParser;
use ProgramCms\ThemeBundle\Parser\BlockTokenParser;
use ProgramCms\ThemeBundle\Parser\ContainerTokenParser;
use ProgramCms\ThemeBundle\Parser\CssTokenParser;
use ProgramCms\ThemeBundle\Parser\JsTokenParser;
use ProgramCms\ThemeBundle\Parser\LayoutTokenParser;
use ProgramCms\ThemeBundle\Parser\MoveTokenParser;
use ProgramCms\ThemeBundle\Parser\PageTokenParser;
use ProgramCms\ThemeBundle\Parser\ReferenceBlockTokenParser;
use ProgramCms\ThemeBundle\Parser\ReferenceContainerTokenParser;
use ProgramCms\ThemeBundle\Parser\TitleTokenParser;
use ProgramCms\ThemeBundle\Parser\UpdateTokenParser;
use ProgramCms\UiBundle\Twig\Parser\FieldsetTokenParser;
use ProgramCms\UiBundle\Twig\Parser\FieldTokenParser;
use ProgramCms\UiBundle\Twig\Parser\FormTokenParser;
use ProgramCms\UiBundle\Twig\Parser\UiComponentTokenParser;

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
        // TODO: Re-Design this part to be modular
        return [
            new PageTokenParser(),
            new UpdateTokenParser(),
            new LayoutTokenParser(),
            new TitleTokenParser(),
            new ContainerTokenParser(),
            new BlockTokenParser(),
            new ArgumentsTokenParser(),
            new ArgumentTokenParser(),
            new ReferenceBlockTokenParser(),
            new CssTokenParser(),
            new JsTokenParser(),
            new MoveTokenParser(),
            new ReferenceContainerTokenParser(),
            new UiComponentTokenParser(),
            new FormTokenParser(),
            new FieldsetTokenParser(),
            new FieldTokenParser()
        ];
    }
}