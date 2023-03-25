<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


class EFReferenceContainerNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($containerName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');

        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFBlockNode):
                    $blockName = $node->getAttribute('blockName');
                    $blockClass = $node->getAttribute('blockClass');
                    $blockTemplate = $node->getAttribute('blockTemplate');
                    $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfBlock('$blockName', '$blockClass', '$blockTemplate', '$containerName');");
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                    $subContainerName = $node->getAttribute('containerName');
                    $subContainerHtmlTag = $node->getAttribute('containerHtmlTag');
                    $subContainerHtmlClass = $node->getAttribute('containerHtmlClass');
                    $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfContainer('$subContainerName', '$containerName', '$subContainerHtmlTag', '$subContainerHtmlClass');");
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}