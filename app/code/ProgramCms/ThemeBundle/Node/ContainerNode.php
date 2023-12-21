<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class ContainerNode
 * @package ProgramCms\ThemeBundle\Node
 */
class ContainerNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($containerName, $containerHtmlTag, $containerHtmlClass, $containerIdClass, $before, $after, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName, 'containerHtmlTag' => $containerHtmlTag, 'containerHtmlClass' => $containerHtmlClass, 'containerIdClass' => $containerIdClass, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');

        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ProgramCms\ThemeBundle\Node\BlockNode):
                    $blockName = $node->getAttribute('blockName');
                    $blockClass = $node->getAttribute('blockClass');
                    $blockTemplate = $node->getAttribute('blockTemplate');
                    $before = $node->getAttribute('before');
                    $after = $node->getAttribute('after');
                    $arguments = [];
                    foreach($node->getNode('body') as $argumentsNode) {
                        if($argumentsNode instanceof \ProgramCms\ThemeBundle\Node\Argument\ArgumentsNode) {
                            $compiler->getEnvironment()->getExtension('ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->getArgumentAsArray($argumentsNode,$arguments);
                        }
                    }
                    $arguments = count($arguments) > 0 ? json_encode($arguments) : '';
                    $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addBlock('$blockName', '$blockClass', '$blockTemplate', '$containerName', '$before', '$after', '$arguments');");
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\ContainerNode):
                    $subContainerName = $node->getAttribute('containerName');
                    $subContainerHtmlTag = $node->getAttribute('containerHtmlTag');
                    $subContainerHtmlClass = $node->getAttribute('containerHtmlClass');
                    $subContainerIdClass = $node->getAttribute('containerIdClass');
                    $before = $node->getAttribute('before');
                    $after = $node->getAttribute('after');
                    $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addContainer('$subContainerName', '$containerName', '$subContainerHtmlTag', '$subContainerHtmlClass', '$subContainerIdClass', '$before', '$after');");
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}