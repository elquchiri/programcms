<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

/**
 * Class AbstractBlock
 * @package ProgramCms\CoreBundle\View\Element
 */
abstract class AbstractBlock extends \ProgramCms\CoreBundle\Model\DataObject
{
    private array $childBlocks = [];
    /**
     * Twig Environment instance
     * @var \Twig\Environment
     */
    protected \Twig\Environment $environment;

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
     * Retrieve child block content by name
     *
     * @param string $alias
     * @return string
     */
    public function getChildHtml(string $name): string
    {
        $childBlock = $this->getChildBlock($name);
        return $childBlock->toHtml();
    }

    /**
     * @param string $alias
     * @throws \InvalidArgumentException
     * @return object
     */
    public function getChildBlock(string $name): object
    {
        if (!isset($this->childBlocks[$name])) {
            throw new \InvalidArgumentException("Requested ChildBlock Not found");
        }

        return $this->childBlocks[$name];
    }

    /**
     * @param $childBlockName
     * @param $childBlockInstance
     */
    public function addChildBlock($childBlockName, $childBlockInstance)
    {
        $this->childBlocks[$childBlockName] = $childBlockInstance;
    }

    /**
     * Get all block's childs
     * @return array
     */
    public function getChildBlocks(): array
    {
        return $this->childBlocks;
    }
}