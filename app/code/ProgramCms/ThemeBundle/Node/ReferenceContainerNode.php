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
            $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addElementToRemove('$containerName');");
        }
    }
}