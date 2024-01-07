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
 * Class ReferenceContainerNode
 * @package ProgramCms\ThemeBundle\Node
 */
class ReferenceContainerNode extends AbstractNode implements \Twig\Node\NodeCaptureInterface
{

    /**
     * @param Compiler $compiler
     * @return void
     */
    protected function _compile(Compiler &$compiler)
    {
        $containerName = $this->getAttribute('name');
        $remove = (bool) $this->getAttribute('remove');

        if($remove) {
            // Remove container from Elements Tree
            $compiler
                ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addElementToRemove('$containerName')")
                ->raw(";\n");
        }

        if($this->hasAttribute('parent')) {
            $parentNode = $this->getAttribute('parent');
            if($parentNode instanceof LayoutNode) {
                $templateName = $parentNode->getTemplateName();
                foreach ($this->getNode('body') as $subContainerNode) {
                    if ($subContainerNode instanceof \ProgramCms\ThemeBundle\Node\ContainerNode) {
                        $subContainerName = $subContainerNode->getAttribute('name');
                        $compiler
                            ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->trackElementWithFileName('$templateName', '$subContainerName')")
                            ->raw(";\n");
                    }
                }
            }
        }
    }
}