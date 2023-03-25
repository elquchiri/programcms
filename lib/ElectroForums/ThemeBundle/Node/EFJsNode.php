<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


class EFJsNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($jsFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['js_files' => $jsFiles], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $jsFiles = implode(',', $this->getAttribute('js_files'));
        $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEFJs('$jsFiles');");
    }
}