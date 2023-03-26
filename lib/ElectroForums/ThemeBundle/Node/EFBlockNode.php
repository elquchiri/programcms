<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


class EFBlockNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($blockName, $blockClass, $blockTemplate, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['blockName' => $blockName, 'blockClass' => $blockClass, 'blockTemplate' => $blockTemplate], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $blockName = $this->getAttribute('blockName');

        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFBlockNode):
                    $childBlockName = $node->getAttribute('blockName');
                    $childBlockClass = $node->getAttribute('blockClass');
                    $childBlockTemplate = $node->getAttribute('blockTemplate');
                    $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfChildrenBlock('$childBlockName', '$childBlockClass', '$childBlockTemplate', '$blockName');");
                    break;
                case ($node instanceof \Twig\Node\TextNode):
                    if(empty(trim($node->getAttribute('data')))) {
                        break;
                    }
                default:
                    throw new \Exception(sprintf("%s is not a supported Tag inside EFBlocks.", $node->getNodeTag()));
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}