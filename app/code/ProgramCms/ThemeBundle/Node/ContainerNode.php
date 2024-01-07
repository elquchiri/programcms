<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Compiler;

/**
 * Class ContainerNode
 * @package ProgramCms\ThemeBundle\Node
 */
class ContainerNode extends AbstractNode implements \Twig\Node\NodeCaptureInterface
{

    /**
     * @param Compiler $compiler
     * @return void
     */
    protected function _compile(Compiler &$compiler)
    {
        $containerName = $this->getAttribute('name');

        if($this->hasAttribute('parent')) {
            $parentNode = $this->getAttribute('parent');

            if($parentNode instanceof LayoutNode) {
                // Add root container
                $templateName = $parentNode->getTemplateName();
                $compiler
                    ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addContainer('$containerName')")
                    ->raw(";\n");
                $compiler
                    ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->trackElementWithFileName('$templateName', '$containerName')")
                    ->raw(";\n");
            }else{
                $parentName = $parentNode->getAttribute('name');
                $subContainerHtmlTag = $this->getAttribute('containerHtmlTag');
                $subContainerHtmlClass = $this->getAttribute('containerHtmlClass');
                $subContainerIdClass = $this->getAttribute('containerIdClass');
                $before = $this->getAttribute('before');
                $after = $this->getAttribute('after');
                $compiler
                    ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addContainer('$containerName', '$parentName', '$subContainerHtmlTag', '$subContainerHtmlClass', '$subContainerIdClass', '$before', '$after')")
                    ->raw(";\n");
            }
        }
    }
}