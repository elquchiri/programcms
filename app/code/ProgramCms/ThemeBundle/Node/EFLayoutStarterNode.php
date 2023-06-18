<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class EFLayoutStarterNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFLayoutStarterNode extends \Twig\Node\Node implements \Twig\Node\NodeOutputInterface
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('body'))
            ->write("\$efCss = \$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->getEfCss();")
            ->write("\$efJs = \$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->getEfJs();")
            ->write("\$efTitle = \$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->getEfTitle();")

            ->write("\$html = \$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->renderPage();")
            //->write("echo '<pre>'; var_dump(\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->getEfContainers());");
            ->write("echo \$this->env->render('@ProgramCmsTheme/base.html.twig', ['efCss' => \$efCss, 'efJs' => \$efJs, 'efTitle' => \$efTitle, 'html' => \$html]);");
    }
}