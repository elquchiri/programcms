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
    public function __construct($containerName, $remove, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName, 'remove' => $remove], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');
        $remove = (bool) $this->getAttribute('remove');

        if($remove) {
            // Remove container from Elements Tree
            $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->removeElement('$containerName');");
        }else {
            foreach ($this->getNode('body') as $node) {
                switch ($node) {
                    case ($node instanceof \ElectroForums\ThemeBundle\Node\EFBlockNode):
                        $blockName = $node->getAttribute('blockName');
                        $blockClass = $node->getAttribute('blockClass');
                        $blockTemplate = $node->getAttribute('blockTemplate');
                        $before = $node->getAttribute('before');
                        $after = $node->getAttribute('after');
                        $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfBlock('$blockName', '$blockClass', '$blockTemplate', '$containerName', '$before', '$after');");
                        break;
                    case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                        $subContainerName = $node->getAttribute('containerName');
                        $subContainerHtmlTag = $node->getAttribute('containerHtmlTag');
                        $subContainerHtmlClass = $node->getAttribute('containerHtmlClass');
                        $before = $node->getAttribute('before');
                        $after = $node->getAttribute('after');
                        $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfContainer('$subContainerName', '$containerName', '$subContainerHtmlTag', '$subContainerHtmlClass', '$before', '$after');");
                        break;
                }
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}