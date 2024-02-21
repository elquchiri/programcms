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
 * Class AbstractNodeComponent
 * @package ProgramCms\UiBundle\Twig\Node
 */
abstract class AbstractNodeComponent extends AbstractNode
{
    /**
     * @param Compiler $compiler
     * @return void
     */
    protected function _compile(Compiler &$compiler)
    {
        parent::_compile($compiler);

        if(!$this->hasAttribute('parent')) {
            throw new \InvalidArgumentException("No Parent Node Found");
        }

        $config = array_merge_recursive($this->_configuration(), $this->attributes);
        $parentName = $this->getAttribute('parent')->getAttribute('name');

        $compiler->getEnvironment()->getExtension('ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addUiComponent($config, $parentName);
    }

    /**
     * @return array
     */
    abstract protected function _configuration(): array;
}