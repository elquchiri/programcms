<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


class EFReferenceBlockNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($blockName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['blockName' => $blockName], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $blockName = $this->getAttribute('blockName');

        $compiler
            ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfBlock('$blockName');");

        // TODO: Subcompile to continue processing childBlocks if any
        $compiler->subcompile($this->getNode('body'));
    }
}