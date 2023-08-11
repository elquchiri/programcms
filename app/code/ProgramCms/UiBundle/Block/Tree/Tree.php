<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Tree;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Element\Template\Context;

/**
 * Class Tree
 * @package ProgramCms\UiBundle\Block\Tree
 */
class Tree extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * Tree constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectManager = $objectManager;
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        if($this->hasData('dataProvider')) {
            $config = $this->getData('dataProvider');
            $dataProvider = $this->objectManager->create($config['class']);
            return $dataProvider->getData();
        }
        return [];
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
            <a href="#" class="tree-group" id="collapse">Collapse All</a> | <a href="#" class="tree-group" id="expand">Expand All</a>
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