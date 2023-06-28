<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class ReferenceContainerNode
 * @package ProgramCms\ThemeBundle\Node
 */
class ReferenceContainerNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
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
            $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->removeElement('$containerName');");
        }else {
            foreach ($this->getNode('body') as $node) {
                switch ($node) {
                    case ($node instanceof \ProgramCms\ThemeBundle\Node\BlockNode):
                        $blockName = $node->getAttribute('blockName');
                        $blockClass = $node->getAttribute('blockClass');
                        $blockTemplate = $node->getAttribute('blockTemplate');
                        $before = $node->getAttribute('before');
                        $after = $node->getAttribute('after');
                        $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addBlock('$blockName', '$blockClass', '$blockTemplate', '$containerName', '$before', '$after');");
                        break;
                    case ($node instanceof \ProgramCms\ThemeBundle\Node\ContainerNode):
                        $subContainerName = $node->getAttribute('containerName');
                        $subContainerHtmlTag = $node->getAttribute('containerHtmlTag');
                        $subContainerHtmlClass = $node->getAttribute('containerHtmlClass');
                        $before = $node->getAttribute('before');
                        $after = $node->getAttribute('after');
                        $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addContainer('$subContainerName', '$containerName', '$subContainerHtmlTag', '$subContainerHtmlClass', '$before', '$after');");
                        break;
                }
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}