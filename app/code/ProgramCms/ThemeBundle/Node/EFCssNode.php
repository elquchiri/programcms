<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class EFCssNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFCssNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($cssFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['css_files' => $cssFiles], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $cssFiles = implode(',', $this->getAttribute('css_files'));
        $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->addEFCss('$cssFiles');");
    }
}