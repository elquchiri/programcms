<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Exception;

/**
 * Class BlockNode
 * @package ProgramCms\ThemeBundle\Node
 */
class BlockNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    /**
     * BlockNode constructor.
     * @param $blockName
     * @param $blockClass
     * @param $blockTemplate
     * @param $before
     * @param $after
     * @param $body
     * @param $lineno
     * @param null $tag
     */
    public function __construct($blockName, $blockClass, $blockTemplate, $before, $after, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['blockName' => $blockName, 'blockClass' => $blockClass, 'blockTemplate' => $blockTemplate, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    /**
     * @param \Twig\Compiler $compiler
     * @throws Exception
     */
    public function compile(\Twig\Compiler $compiler)
    {
        $blockName = $this->getAttribute('blockName');
        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ProgramCms\ThemeBundle\Node\BlockNode):
                    $childBlockName = $node->getAttribute('blockName');
                    $childBlockClass = $node->getAttribute('blockClass');
                    $childBlockTemplate = $node->getAttribute('blockTemplate');
                    $before = $node->getAttribute('before');
                    $after = $node->getAttribute('after');
                    $arguments = [];
                    foreach($node->getNode('body') as $argumentsNode) {
                        if($argumentsNode instanceof \ProgramCms\ThemeBundle\Node\Argument\ArgumentsNode) {
                            $compiler->getEnvironment()->getExtension('ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->getArgumentAsArray($argumentsNode,$arguments);
                        }
                    }
                    $arguments = count($arguments) > 0 ? json_encode($arguments) : '';
                    $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addBlock('$childBlockName', '$childBlockClass', '$childBlockTemplate', '$blockName', '$before', '$after', '$arguments');");
                    break;
                case ($node instanceof \Twig\Node\TextNode):
                    if(empty(trim($node->getAttribute('data')))) {
                        break;
                    }
//                default:
//                    throw new Exception(sprintf("%s is not a supported Tag inside Blocks.", $node->getNodeTag()));
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}