<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View;

use Exception;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\Layout\Element;
use ProgramCms\ThemeBundle\Model\PageLayout;

/**
 * Class Layout
 * @package ProgramCms\CoreBundle\View
 */
class Layout implements LayoutInterface
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;
    /**
     * @var Page\Config
     */
    protected Page\Config $config;
    /**
     * @var ObjectManager
     */
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var \ProgramCms\CoreBundle\View\Layout\Data\Structure
     */
    protected \ProgramCms\CoreBundle\View\Layout\Data\Structure $structure;
    /**
     * PageLayout Model, used to get page layout content
     * @var PageLayout
     */
    protected PageLayout $pageLayout;
    /**
     * Saves Page Layouts
     * @var array
     */
    protected array $pageLayouts = [];
    /**
     * Stores the last page layout, current page
     * @var string
     */
    protected string $currentPageLayout;
    /**
     * Holds blocks objects
     * @var array
     */
    protected array $blocks;
    /**
     * Cache of elements to output during rendering
     * @var array
     */
    protected array $_output = [];
    /**
     * @var array
     */
    protected array $_elementsToRemove = [];
    /**
     * @var array
     */
    protected array $_elementsToMove = [];
    /**
     * Holds All Css files
     * @var array
     */
    protected array $css = [];
    /**
     * Holds All Js files
     * @var array
     */
    protected array $js = [];
    /**
     * Used to remove unused containers by keeping only those of the last layout
     * @var array
     */
    protected array $elementsWithFileName;

    /**
     * Layout constructor.
     * @param Layout\Data\Structure $structure
     * @param PageLayout $pageLayout
     * @param BundleManager $bundleManager
     * @param Page\Config $config
     * @param ObjectManager $objectManager
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Layout\Data\Structure $structure,
        PageLayout $pageLayout,
        BundleManager $bundleManager,
        \ProgramCms\CoreBundle\View\Page\Config $config,
        ObjectManager $objectManager
    )
    {
        $this->blocks = [];
        $this->elementsWithFileName = [];
        $this->pageLayout = $pageLayout;
        $this->currentPageLayout = "";
        $this->bundleManager = $bundleManager;
        $this->config = $config;
        $this->objectManager = $objectManager;
        $this->structure = $structure;
    }

    /**
     * Add parent containers to output
     * @return $this
     */
    protected function addToOutputRootContainers(): static
    {
        foreach ($this->structure->getElements() as $name => $element) {
            if ($element['type'] === Element::TYPE_CONTAINER && empty($element['parent'])) {
                $this->addOutputElement($name);
            }
        }
        return $this;
    }

    /**
     * Generate Layout Elements
     * @throws Exception
     */
    public function generateElements()
    {
        $this->_processElementsToMove();
        $this->_processElementsToRemove();
        $this->_cleanUnusedPageLayoutContainers();
    }

    /**
     * Add Block to structure
     * @throws Exception
     */
    public function addBlock($name, $class, $blockTemplate = '', $parent = '', $before = '', $after = '', $arguments = ''): ?object
    {
        $data = [];
        $data['before'] ??= $before;
        $data['after'] ??= $after;
        $block = $this->_createBlock($class, $name, ['template' => $blockTemplate]);
        if(!empty($arguments)) {
            $block->addData(json_decode($arguments, true));
        }
        $name = $this->structure->createStructuralElement(
            $name,
            Element::TYPE_BLOCK,
            $data
        );
        $this->setBlock($name, $block);
        if ($parent) {
            $this->structure->setAsChild($name, $parent);
        }
        $block->setNameInLayout($name);
        $block->setTemplateContext($block);
        $block->setLayout($this);

        if(!empty($before)) {
            $this->addElementToMove($name, $parent, $before, '');
        }else if(!empty($after)) {
            $this->addElementToMove($name, $parent, '', $after);
        }

        return $block;
    }

    /**
     * Add Container to structure
     * @return $this
     * @throws Exception
     */
    public function addContainer($name, $parent = '', $containerHtmlTag = '', $containerHtmlClass = '', $subContainerIdClass = '', $before = '', $after = ''): static
    {
        $data = [];
        $data['htmlTag'] ??= $containerHtmlTag;
        $data['htmlClass'] ??= $containerHtmlClass;
        $data['htmlId'] ??= $subContainerIdClass;
        $data['before'] ??= $before;
        $data['after'] ??= $after;
        $name = $this->structure->createStructuralElement($name, Element::TYPE_CONTAINER, $data);
        if ($parent) {
            $this->structure->setAsChild($name, $parent);
        }
        if(!empty($before)) {
            $this->addElementToMove($name, $parent, $before, '');
        }else if(!empty($after)) {
            $this->addElementToMove($name, $parent, '', $after);
        }

        return $this;
    }

    /**
     * @param $elementName
     * @param $targetElementName
     * @param $before
     * @param $after
     */
    private function _moveElement($element, $destination, $before, $after)
    {
        $alias = $this->structure->getChildAlias($this->structure->getParentId($element), $element);
        $this->structure->unsetChild($element, $alias);
        if(!empty($before)) {
            $siblingName = $before;
            $isAfter = false;
        }else{
            $siblingName = $after;
            $isAfter = true;
        }
        try {
            $this->structure->setAsChild($element, $destination);
            $this->structure->reorderChildElement($destination, $element, $siblingName, $isAfter);
        } catch (\OutOfBoundsException $e) {
            // Log 'Broken reference: ' . $e->getMessage()
        }
    }

    /**
     * @param $element
     * @param $destination
     * @param $before
     * @param $after
     */
    public function addElementToMove($element, $destination, $before, $after)
    {
        $this->_elementsToMove[] = [
            'element' => $element,
            'destination' => $destination,
            'before' => $before,
            'after' => $after
        ];
    }

    /**
     * Remove element from structure
     * @param $name
     * @throws Exception
     */
    public function addElementToRemove($name)
    {
        $this->_elementsToRemove[] = $name;
    }

    /**
     * Remove all childs of an element
     * @throws Exception
     */
    public function cleanElementChildren($name)
    {
        $children = $this->getChildNames($name);
        foreach($children as $childName) {
            $this->addElementToRemove($childName);
        }
    }

    /**
     * @param $templateName
     * @param $elementName
     */
    public function trackElementWithFileName($templateName, $elementName)
    {
        $this->elementsWithFileName[$templateName][] = $elementName;
    }

    /**
     * @param $templateName
     * @param $handlerName
     */
    public function trackHandlerWithFileName($templateName, $handlerName)
    {
        $this->elementsWithFileName[$templateName]['handlers'][] = $handlerName;
    }

    /**
     * @param $pageLayoutName
     */
    public function addPageLayout($pageLayoutName)
    {
        if ($pageLayoutName) {
            $this->pageLayouts[$pageLayoutName] = $pageLayoutName;
        }
    }

    /**
     * @return array
     */
    public function getPageLayouts(): array
    {
        return $this->pageLayouts;
    }

    /**
     * @param $pageLayout
     * @return bool
     */
    public function canAddPageLayout($pageLayout): bool
    {
        return !isset($this->pageLayouts[$pageLayout]);
    }

    /**
     * @param $pageLayout
     */
    public function setCurrentPageLayout($pageLayout)
    {
        $this->currentPageLayout = $pageLayout;
    }

    /**
     * @return string
     */
    public function getCurrentPageLayout(): string
    {
        return $this->currentPageLayout;
    }

    /**
     * Adds CSS files to be added to page
     * @param $cssTags
     */
    public function addCss($cssTags)
    {
        foreach (explode(',', $cssTags) as $css) {
            if (!empty($css) || $css != '') {
                $this->css[] = $css;
            }
        }
    }

    /**
     * @return array
     */
    public function getCss(): array
    {
        return $this->css;
    }

    /**
     * Adds JS files to be added to page
     * @param $jsTags
     */
    public function addJs($jsTags)
    {
        foreach (explode(',', $jsTags) as $js) {
            if (!empty($js) || $js != '') {
                $this->js[] = $js;
            }
        }
    }

    /**
     * @return array
     */
    public function getJs(): array
    {
        return $this->js;
    }

    /**
     * @return PageLayout
     */
    public function getPageLayout(): PageLayout
    {
        return $this->pageLayout;
    }

    /**
     * Helper method to set title from configuration
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->config->getTitle()->set($title);
    }

    /**
     * Helper method to retrieve title from configuration
     * @return string
     */
    public function getTitle(): string
    {
        return $this->config->getTitle()->get();
    }

    /**
     * Render Block element
     * @param $name
     * @return string
     */
    protected function _renderBlock($name): string
    {
        $block = $this->getBlock($name);
        return $block ? $block->toHtml() : '';
    }

    /**
     * @param $name
     * @return string
     */
    protected function _renderUiComponent($name): string
    {
        $uiComponent = $this->getUiComponent($name);
        return $uiComponent ? $uiComponent->toHtml() : '';
    }

    /**
     * Render Container element
     * @param $name
     * @return string
     * @throws Exception
     */
    protected function _renderContainer($name): string
    {
        $html = '';
        $children = $this->getChildNames($name);
        foreach ($children as $child) {
            $html .= $this->renderElement($child);
        }
        if ($html == '' || !$this->structure->getAttribute($name, Element::CONTAINER_OPT_HTML_TAG)) {
            return $html;
        }

        $htmlId = $this->structure->getAttribute($name, Element::CONTAINER_OPT_HTML_ID);
        if ($htmlId) {
            $htmlId = ' id="' . $htmlId . '"';
        }

        $htmlClass = $this->structure->getAttribute($name, Element::CONTAINER_OPT_HTML_CLASS);
        if ($htmlClass) {
            $htmlClass = ' class="' . $htmlClass . '"';
        }

        $htmlTag = $this->structure->getAttribute($name, Element::CONTAINER_OPT_HTML_TAG);

        $html = sprintf('<%1$s%2$s%3$s>%4$s</%1$s>', $htmlTag, $htmlId, $htmlClass, $html);

        return $html;
    }

    /**
     * @param string $pageLayout
     * @param array $pageLayouts
     */
    private function _removePageLayout(string $pageLayout, array &$pageLayouts)
    {
        $pageLayoutArray = $pageLayouts[$pageLayout];
        if(isset($pageLayoutArray['handlers'])) {
            foreach($pageLayoutArray['handlers'] as $handler) {
                $this->_removePageLayout($handler, $pageLayouts);
            }
        }
        unset($pageLayouts[$pageLayout]);
    }

    /**
     * Clean Unused Page Layout containers in the structure
     */
    private function _cleanUnusedPageLayoutContainers(): void
    {
        $currentPageLayout = $this->elementsWithFileName[$this->currentPageLayout];
        $pageLayouts = $this->elementsWithFileName;
        if(isset($currentPageLayout['handlers'])) {
            foreach($currentPageLayout['handlers'] as $layout) {
                $this->_removePageLayout($layout, $pageLayouts);
            }
        }
        unset($pageLayouts[$this->currentPageLayout]);

        if(count($pageLayouts)) {
            // Clean unneeded Page Layout containers
            foreach($pageLayouts as $pageLayoutToRemove) {
                foreach($pageLayoutToRemove as $key => $pageLayoutContainer) {
                    if ($key != 'handlers') {
                        $this->structure->unsetElement($pageLayoutContainer);
                    }
                }
            }
        }
    }

    /**
     * Add an element to output
     * @param string $name
     * @return $this
     */
    public function addOutputElement(string $name): static
    {
        $this->_output[$name] = $name;
        return $this;
    }

    /**
     * Remove an element from output
     *
     * @param string $name
     * @return $this
     */
    public function removeOutputElement(string $name): static
    {
        if (isset($this->_output[$name])) {
            unset($this->_output[$name]);
        }
        return $this;
    }

    /**
     * Get all blocks marked for output
     * @return string
     * @throws Exception
     */
    public function getOutput(): string
    {
        $this->addToOutputRootContainers();
        $out = '';
        foreach ($this->_output as $name) {
            $out .= $this->renderElement($name);
        }
        return $out;
    }

    /**
     * Create an instance of Block and returns it
     * @param $blockClass
     * @param string $name
     * @param array $arguments
     * @return object|null
     */
    protected function _createBlock($blockClass, string $name, array $arguments = []): ?object
    {
        // Get Block instance from Container class
        $blockClassInstance = $this->objectManager->create($blockClass);

        if(!empty($arguments)) {
            // Init block's arguments in construction step
            $blockClassInstance->setData($arguments);
        }
        if(isset($arguments['template']) && !empty($arguments['template'])) {
            $blockClassInstance->setTemplate($arguments['template']);
        }
        $this->setBlock($name, $blockClassInstance);
        return $blockClassInstance;
    }

    /**
     * Get Block instance by name
     * @param string $name
     * @return Element\AbstractBlock
     */
    public function getBlock(string $name): \ProgramCms\CoreBundle\View\Element\AbstractBlock
    {
        return $this->blocks[$name] ?? false;
    }

    /**
     * @param $name
     * @return Element\AbstractBlock
     */
    public function getUiComponent($name)
    {
        return $this->getBlock($name);
    }

    /**
     * @param string $parentName
     * @param string $alias
     * @return false|mixed|Element\AbstractBlock
     * @throws Exception
     */
    public function getChildBlock(string $parentName, string $alias): mixed
    {
        $name = $this->structure->getChildId($parentName, $alias);
        if ($this->isBlock($name)) {
            return $this->getBlock($name);
        }
        return false;
    }

    /**
     * @param string $parentName
     * @param string $elementName
     * @return $this
     * @throws Exception
     */
    public function setChild(string $parentName, string $elementName): static
    {
        $this->structure->setAsChild($elementName, $parentName);
        return $this;
    }

    /**
     * Reorder a child of a specified element
     * @param string $parentName
     * @param string $childName
     * @param string|int|null $offsetOrSibling
     * @param bool $after
     * @return void
     * @throws Exception
     */
    public function reorderChild(string $parentName, string $childName, $offsetOrSibling, bool $after = true)
    {
        $this->structure->reorderChildElement($parentName, $childName, $offsetOrSibling, $after);
    }

    /**
     * Get child name by alias
     *
     * @param string $parentName
     * @param string $alias
     * @return bool|string
     */
    public function getChildName(string $parentName, string $alias): bool|string
    {
        return $this->structure->getChildId($parentName, $alias);
    }

    /**
     * @param string $parentName
     * @return array
     */
    public function getChildNames(string $parentName): array
    {
        return array_keys($this->structure->getChildren($parentName));
    }

    /**
     * @param $parentName
     * @param $alias
     * @return $this
     */
    public function unsetChild($parentName, $alias): self
    {
        $this->structure->unsetChild($parentName, $alias);
        return $this;
    }

    /**
     * Get Layout Block instances
     * @return array
     */
    public function getAllBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * Get ChildBlocks as a List of Objects
     * @param string $parentName
     * @return array
     */
    public function getChildBlocks(string $parentName): array
    {
        $blocks = [];
        foreach ($this->structure->getChildren($parentName) as $childName => $alias) {
            $block = $this->getBlock($childName);
            if ($block) {
                $blocks[$alias] = $block;
            }
        }
        return $blocks;
    }

    /**
     * @param string $childName
     * @return string|bool
     */
    public function getParentName(string $childName): string|bool
    {
        return $this->structure->getParentId($childName);
    }

    /**
     * @param $name
     * @param $block
     * @return $this
     */
    public function setBlock($name, $block): static
    {
        $this->blocks[$name] = $block;
        return $this;
    }

    /**
     * @param $type
     * @param string $name
     * @param array $arguments
     * @return mixed|void
     * @throws Exception
     */
    public function createBlock($type, string $name = '', array $arguments = [])
    {
        $name = $this->structure->createStructuralElement($name, Element::TYPE_BLOCK);
        $block = $this->_createBlock($type, $name, $arguments);
        $block->setTemplateContext($block);
        $block->setNameInLayout($name);
        $block->setLayout($this);
        return $block;
    }

    /**
     * @param $name
     * @return bool
     * @throws Exception
     */
    public function isBlock($name): bool
    {
        if ($this->structure->hasElement($name)) {
            return Element::TYPE_BLOCK === $this->structure->getAttribute($name, 'type');
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     * @throws Exception
     */
    public function isUiComponent($name): bool
    {
        if ($this->structure->hasElement($name)) {
            return Element::TYPE_BLOCK === $this->structure->getAttribute($name, 'type');
        }
        return false;
    }

    /**
     * Render an Element
     * @param $name
     * @return string
     * @throws Exception
     */
    public function renderElement($name): string
    {
        try {
            if ($this->isUiComponent($name)) {
                $result = $this->_renderUiComponent($name);
            }elseif ($this->isBlock($name)) {
                $result = $this->_renderBlock($name);
            } else {
                $result = $this->_renderContainer($name);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     * Process elements to remove
     * @throws Exception
     */
    private function _processElementsToRemove(): void
    {
        foreach($this->_elementsToRemove as $element) {
            $this->structure->unsetElement($element);
        }
    }

    /**
     * Process elements to move
     */
    private function _processElementsToMove(): void
    {
        foreach($this->_elementsToMove as $element) {
            $this->_moveElement($element['element'], $element['destination'], $element['before'], $element['after']);
        }
    }

    /**
     * @param $argument
     * @param $argumentArray
     * @throws Exception
     */
    public function getArgumentAsArray($argument, &$argumentArray)
    {
        foreach($argument->getNode('body') as $arg) {
            if($arg instanceof \ProgramCms\ThemeBundle\Node\Argument\ArgumentNode) {
                $argumentName = $arg->getAttribute('argumentName');
                $argumentType = $arg->getAttribute('argumentType');
                if($arg->getAttribute('argumentType') == 'array') {
                    $argumentArray[$argumentName] = [];
                    $this->getArgumentAsArray($arg, $argumentArray[$argumentName]);
                }else if($argumentType == 'boolean') {
                    $argumentArray[$argumentName] = $arg->getNode('body')->getAttribute('data') == 'true';
                }else if($argumentType == 'string') {
                    $argumentArray[$argumentName] = addslashes($arg->getNode('body')->getAttribute('data'));
                }else if($argumentType == 'integer') {
                    $argumentArray[$argumentName] = is_int($arg->getNode('body')->getAttribute('data')) ? (int) $arg->getNode('body')->getAttribute('data') : 0;
                }else if($argumentType == 'double') {
                    $argumentArray[$argumentName] = is_double($arg->getNode('body')->getAttribute('data')) ? (double) $arg->getNode('body')->getAttribute('data') : 0.0;
                }else{
                    throw new \Exception(
                        sprintf("Unknown Type %s of Argument %s", $argumentType, $argumentName)
                    );
                }
            }
        }
    }

    /**
     * Used internally to debug page elements
     * @return Layout\Data\Structure
     */
    public function getStructure()
    {
        return $this->structure;
    }
}