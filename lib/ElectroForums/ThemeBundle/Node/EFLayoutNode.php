<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;



class EFLayoutNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        // Retrieve the template file
        $templateName = $this->getTemplateName();

        foreach($this->getNode('body') as $node) {
            switch ($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                    $containerName = $node->getAttribute('containerName');
                    $compiler
                        ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfRootContainer('$containerName');")
                        ->raw("\n");
                    $compiler
                        ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfRootContainer('$containerName');")
                        ->raw("\n");
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFReferenceContainerNode):
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}