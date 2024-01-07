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
 * Class JsNode
 * @package ProgramCms\ThemeBundle\Node
 */
class JsNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    /**
     * JsNode constructor.
     * @param $jsFiles
     * @param $lineno
     * @param null $tag
     */
    public function __construct($jsFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['js_files' => $jsFiles], $lineno, $tag);
    }

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $jsFiles = implode(',', $this->getAttribute('js_files'));
        $compiler
            ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addJs('$jsFiles')")
            ->raw(";\n");
    }
}