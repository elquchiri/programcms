<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Compiler;

/**
 * Class CssNode
 * @package ProgramCms\ThemeBundle\Node
 */
class CssNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    /**
     * CssNode constructor.
     * @param $cssFiles
     * @param $lineno
     * @param null $tag
     */
    public function __construct($cssFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['css_files' => $cssFiles], $lineno, $tag);
    }

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $cssFiles = implode(',', $this->getAttribute('css_files'));
        $compiler
            ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addCss('$cssFiles')")
            ->raw(";\n");
    }
}