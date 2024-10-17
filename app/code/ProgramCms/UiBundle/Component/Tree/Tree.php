<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Tree;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Tree
 * @package ProgramCms\UiBundle\Block\Tree
 */
class Tree extends AbstractComponent
{
    const NAME = 'tree';

    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;

    /**
     * Tree constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectManager = $this->getContext()->getObjectManager();
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getDataSourceData()
    {
        if($this->hasData('dataSource')) {
            $config = $this->getData('dataSource')['dataProvider'];
            $dataProvider = $this->objectManager->create($config['class']);
            return $dataProvider->getData();
        }
        return parent::getDataSourceData();
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        return $this->getDataSourceData();
    }

    /**
     * @param $tree
     * @return string
     */
    protected function _generateTreeHtml($tree): string
    {
        $treeHtml = "";
        foreach($tree as $item) {
            $active = isset($item['is_active']) && is_bool($item['is_active']) && $item['is_active'] ? 'active' : '';
            $count = isset($item['count']) && $item['count'] > 0 ? '<span>&middot; ' . $item['count'] . '</span>' : '';
            $url = isset($item['url']) && is_string($item['url']) ? $item['url'] : '';
            $folderIcon = $count > 0 ? 'folder-search' : 'folder-open';
            /**
             * Append Item Label and other data attributes
             */
            $treeHtml .= <<<HTML
            <li>
                <span class="title">
                    <img src="/bundles/programcmsui/images/{$folderIcon}.png"/>
                    <span class="category-name {$active}" data-url="{$url}">
                        {$item['label']}
                        {$count}
                    </span>
                </span>
            HTML;
            /**
             * Process and generate children items
             */
            if(isset($item['children'])) {
                $treeHtml .= <<<HTML
                <ul class="child">
                    {$this->_generateTreeHtml($item['children'])}
                </ul>
                HTML;
            }
            // Close Root item
            $treeHtml .= '</li>';
        }

        return $treeHtml;
    }

    /**
     * @return string
     */
    protected function _generateHtml(): string
    {
        $isOpen = $this->isOpen() ? "true" : "false";
        return <<<HTML
        <div class="category-tree" data-controller="tree" data-tree-open-value="{$isOpen}">
            <a href="#" class="tree-group" id="collapse">{$this->trans('Collapse All')}</a> | <a href="#" class="tree-group" id="expand">{$this->trans('Expand All')}</a>
            <div class="tree">
                <ul>
                    {$this->_generateTreeHtml($this->getTree())}
                </ul>
            </div>
        </div>
        HTML;
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        return $this->_generateHtml();
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->hasData('isOpen') && (bool)$this->getData('isOpen');
    }
}