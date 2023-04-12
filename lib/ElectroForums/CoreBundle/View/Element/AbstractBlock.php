<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CoreBundle\View\Element;


abstract class AbstractBlock
{
    private array $childBlocks = [];

    public function toHtml(): string
    {
        return $this->_toHtml();
    }

    /**
     * Created to be Overridden
     * @return string
     */
    protected function _toHtml(): string
    {
        return '';
    }

    /**
     * Retrieve child block by name
     *
     * @param string $alias
     * @return string
     */
    public function getChildHtml(string $alias): string
    {
        $childBlock = $this->getChildBlock($alias);
        return $childBlock
            ->assign('efBlock', $childBlock)
            ->toHtml();
    }

    /**
     * @param string $alias
     * @throws \InvalidArgumentException
     * @return object
     */
    public function getChildBlock(string $alias): object
    {
        if (!isset($this->childBlocks[$alias])) {
            throw new \InvalidArgumentException("Requested ChildBlock Not found");
        }

        $childBlock = $this->childBlocks[$alias];

        $blockClassReflection = new \ReflectionClass($childBlock['class']);
        $blockClassInstance = $blockClassReflection->newInstance($this->environment);

        $blockClassInstance->setTemplate($childBlock['template']);
        if (isset($childBlock['childs'])) {
            $blockClassInstance->setChildBlocks($childBlock['childs']);
        }

        return $blockClassInstance;
    }

    public function setChildBlocks($childBlocks)
    {
        $this->childBlocks = $childBlocks;
    }

    public function getChildBlocks(): array
    {
        return $this->childBlocks;
    }
}