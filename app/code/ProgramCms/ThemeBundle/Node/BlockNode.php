<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use ProgramCms\ThemeBundle\Node\Argument\ArgumentsNode;
use Twig\Compiler;

/**
 * Class BlockNode
 * @package ProgramCms\ThemeBundle\Node
 */
class BlockNode extends AbstractNode implements \Twig\Node\NodeCaptureInterface
{

    /**
     * @param Compiler $compiler
     * @return void
     */
    protected function _compile(Compiler &$compiler)
    {
        if($this->hasAttribute('parent')) {
            $parentNode = $this->getAttribute('parent');
            $parentName = $parentNode->getAttribute('name');
        }else{
            $parentName = '';
        }
        $blockName = $this->getAttribute('name');
        $blockClass = $this->getAttribute('blockClass');
        $blockTemplate = $this->getAttribute('blockTemplate');
        $before = $this->getAttribute('before');
        $after = $this->getAttribute('after');
        $arguments = [];
        foreach($this->getNode('body') as $argumentsNode) {
            if($argumentsNode instanceof ArgumentsNode) {
                $compiler->getEnvironment()->getExtension('ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->getArgumentAsArray($argumentsNode, $arguments);
            }
        }
        $arguments = count($arguments) > 0 ? json_encode($arguments) : '';
        $compiler->write("\$this->env->getExtension('ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addBlock('$blockName', '$blockClass', '$blockTemplate', '$parentName', '$before', '$after', '$arguments');");
    }
}