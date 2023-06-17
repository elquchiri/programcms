<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class EFJsNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFJsNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($jsFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['js_files' => $jsFiles], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $jsFiles = implode(',', $this->getAttribute('js_files'));
        $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->addEFJs('$jsFiles');");
    }
}