<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class EFContainerNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFContainerNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($containerName, $containerHtmlTag, $containerHtmlClass, $before, $after, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName, 'containerHtmlTag' => $containerHtmlTag, 'containerHtmlClass' => $containerHtmlClass, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');

        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFBlockNode):
                    $blockName = $node->getAttribute('blockName');
                    $blockClass = $node->getAttribute('blockClass');
                    $blockTemplate = $node->getAttribute('blockTemplate');
                    $before = $node->getAttribute('before');
                    $after = $node->getAttribute('after');
                    $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->addEfBlock('$blockName', '$blockClass', '$blockTemplate', '$containerName', '$before', '$after');");
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFContainerNode):
                    $subContainerName = $node->getAttribute('containerName');
                    $subContainerHtmlTag = $node->getAttribute('containerHtmlTag');
                    $subContainerHtmlClass = $node->getAttribute('containerHtmlClass');
                    $before = $node->getAttribute('before');
                    $after = $node->getAttribute('after');
                    $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->addEfContainer('$subContainerName', '$containerName', '$subContainerHtmlTag', '$subContainerHtmlClass', '$before', '$after');");
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}