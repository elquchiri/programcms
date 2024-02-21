<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Node;

use ProgramCms\ThemeBundle\Node\AbstractNode;
use Twig\Compiler;

/**
 * Class UiComponentNode
 * @package ProgramCms\UiBundle\Twig\Node
 */
class UiComponentNode extends AbstractNode implements \Twig\Node\NodeCaptureInterface
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
        $componentName = $this->getAttribute('name');
        $compiler->write("\$this->env->getExtension('ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addUiComponent('$componentName', 'ProgramCms\UiBundle\Block\ComponentWrapper', '$parentName');");
    }
}