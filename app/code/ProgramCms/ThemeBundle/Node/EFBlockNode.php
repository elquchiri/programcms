<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class EFBlockNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFBlockNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($blockName, $blockClass, $blockTemplate, $before, $after, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['blockName' => $blockName, 'blockClass' => $blockClass, 'blockTemplate' => $blockTemplate, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $blockName = $this->getAttribute('blockName');

        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFBlockNode):
                    $childBlockName = $node->getAttribute('blockName');
                    $childBlockClass = $node->getAttribute('blockClass');
                    $childBlockTemplate = $node->getAttribute('blockTemplate');
                    $before = $node->getAttribute('before');
                    $after = $node->getAttribute('after');
                    $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->addEfBlock('$childBlockName', '$childBlockClass', '$childBlockTemplate', '$blockName', '$before', '$after');");
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