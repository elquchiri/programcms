<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View;

/**
 * Class Layout
 * @package ProgramCms\CoreBundle\View
 */
class Layout implements LayoutInterface
{
    /**
     * @var \ProgramCms\CoreBundle\Model\Utils\BundleManager
     */
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    /**
     * @var Page\Config
     */
    protected Page\Config $config;
    /**
     * @var \ProgramCms\CoreBundle\Model\ObjectManager
     */
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;
    /**
     * PageLayout Model, used to get page layout content
     * @var \ProgramCms\ThemeBundle\Model\PageLayout
     */
    private \ProgramCms\ThemeBundle\Model\PageLayout $pageLayout;
    /**
     * Saves Page Layouts
     * @var array
     */
    private array $pageLayouts = [];
    /**
     * Stores the last page layout, current page
     * @var string
     */
    private string $currentPageLayout;
    /**
     * Holds Page key,value elements Tree
     * @var array
     */
    private array $elements;
    /**
     * Holds blocks objects
     * @var array
     */
    private array $blocks;
    /**
     * Holds All Css files
     * @var array
     */
    private array $css = [];
    /**
     * Holds All Js files
     * @var array
     */
    private array $js = [];
    /**
     * Used to remove unused containers by keeping only those of the last layout
     * @var array
     */
    private array $elementsWithFileName;

    public function __construct(
        \ProgramCms\ThemeBundle\Model\PageLayout $pageLayout,
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        \ProgramCms\CoreBundle\View\Page\Config $config,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        $this->elements = [];
        $this->blocks = [];
        $this->elementsWithFileName = [];
        $this->pageLayout = $pageLayout;
        $this->currentPageLayout = "";
        $this->bundleManager = $bundleManager;
        $this->config = $config;
        $this->objectManager = $objectManager;
    }

    /**
     * @param $containerName
     */
    public function addRootContainer($containerName)
    {
        if (!count($this->elements)) {
            $this->elements[$containerName] = [
                'type' => 'container'
            ];
        }
    }
    /**
     * @throws \Exception
     */
    public function addBlock($blockName, $blockClass, $blockTemplate, $containerParent, $before = null, $after = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->elements, $containerParent, $containerPaths);

        if ($targetContainer) {
            $elementArguments = [
                'type' => 'block',
                'class' => $blockClass,
                'template' => ''
            ];
            if(!empty($blockTemplate)) {
                $elementArguments['template'] = $blockTemplate;
            }
            if(!empty($before)) {
                $elementArguments['before'] = $before;
            }
            if(!empty($after)) {
                $elementArguments['after'] = $after;
            }
            $this->addElement($containerPaths, $blockName, $elementArguments);
            $block = $this->_createBlock($blockClass, $blockName, $elementArguments);
            $this->setBlock($blockName, $block);
        } else {
            // Throws Exception if EFContainer's parent not found
            throw new \Exception(sprintf("Cant insert %s, EFContainer's parent \"%s\" not found.", $blockName, $containerParent));
        }
    }

    /**
     * @param $blockName
     * @param $arguments
     */
    public function setArguments($blockName, $arguments)
    {
        $nestedElement = &$this->elements;
        $path = [];
        $targetElement = $this->findElementPath($this->elements, $blockName, $path);

        if($targetElement) {
            foreach ($path as $index => $key) {
                // Update $nestedContainer to point to the nested array corresponding to the current key
                if ($index < count($path) - 1) {
                    $nestedElement = &$nestedElement[$key]['childs'];
                } else {
                    $nestedElement = &$nestedElement[$key];
                }
            }
            $nestedElement['arguments'] = json_decode($arguments, true);
        }
    }

    /**
     * Add Container to Elements Tree
     * @throws \Exception
     */
    public function addContainer($containerName, $containerParent = null, $containerHtmlTag = null, $containerHtmlClass = null, $before = null, $after = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->elements, $containerParent, $containerPaths);

        if ($targetContainer) {
            $container = [
                'type' => 'container'
            ];
            if(!empty($containerHtmlTag)) {
                $container['htmlTag'] = $containerHtmlTag;
            }
            if(!empty($containerHtmlClass)) {
                $container['htmlClass'] = $containerHtmlClass;
            }
            if(!empty($before)) {
                $container['before'] = $before;
            }
            if(!empty($after)) {
                $container['after'] = $after;
            }
            $this->addElement($containerPaths, $containerName, $container);
        } else {
            // Throws Exception if EFContainer's parent not found
            throw new \Exception(sprintf("Cant insert %s, EFContainer's parent \"%s\" not found.", $containerName, $containerParent));
        }
    }

    /**
     * @param $elementName
     * @param $targetElementName
     * @param $before
     * @param $after
     */
    public function moveElement($elementName, $targetElementName, $before, $after)
    {
        $element = &$this->elements;

        $elementPath = [];
        $targetElementPath = [];

        // Find element
        $elementArray = $this->findElementPath($element, $elementName, $elementPath);
        if(!empty($before)) {
            $elementArray['before'] = $before;
        }else if(!empty($after)) {
            $elementArray['after'] = $after;
        }else{
            $elementArray['after'] = '-';
        }

        // Find target element (destination)
        $this->findElementPath($this->elements, $targetElementName, $targetElementPath);

        // Remove Element from his original position, make it nullable
        $this->removeElement($elementName);

        if(!empty($targetElementPath)) {
            // Add Element
            $this->addElement($targetElementPath, $elementName, $elementArray);
        }
    }

    /**
     * @param $containerName
     * @param $container
     * @param $nestedContainer
     * @param $priority
     */
    private function addElementWithPriority($containerName, $container, &$nestedContainer, $priority)
    {
        $targetElementName = $container[$priority];
        if($targetElementName == '-') {
            switch($priority) {
                case 'before':
                    $nestedContainer = [$containerName => $container] + $nestedContainer;
                    break;
                case 'after':
                    $nestedContainer = $nestedContainer + [$containerName => $container];
                    break;
            }
        }else if(isset($nestedContainer[$targetElementName])) {
            // gets position of the element inside his parent $nestedContainer
            $position = array_flip(array_keys($nestedContainer))[$targetElementName];
            switch($priority) {
                case 'before':
                    $arr1 = array_slice($nestedContainer,0, $position);
                    $arr2 = array_slice($nestedContainer, $position, count($nestedContainer));
                    $nestedContainer = $arr1 + [$containerName => $container] + $arr2;
                    break;
                case 'after':
                    $arr3 = array_slice($nestedContainer,0, $position + 1);
                    $arr4 = array_slice($nestedContainer, $position + 1, count($nestedContainer));
                    $nestedContainer = $arr3 + [$containerName => $container] + $arr4;
                    break;
            }
        }
    }

    /**
     * Remove element from Tree
     * @param $name
     */
    public function removeElement($name)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->elements, $name, $containerPaths);
        if ($targetContainer) {
            $nestedContainer = &$this->elements;
            foreach ($containerPaths as $index => $key) {
                // Update $nestedContainer to point to the nested array corresponding to the current key
                if($index < count($containerPaths) - 1) {
                    $nestedContainer = &$nestedContainer[$key]['childs'];
                }else{
                    $nestedContainer = &$nestedContainer[$key];
                }
            }
            // Make element nullable
            $nestedContainer = NULL;
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
     * @return array
     */
    public function getElementsWithFileName(): array
    {
        return $this->elementsWithFileName;
    }

    /**
     * @param $efContainers
     * @param $containerName
     * @param array $path
     * @return null
     */
    public function findElementPath($efContainers, $elementName, &$path = [])
    {
        foreach ($efContainers as $containerKey => $container) {
            if ($containerKey == $elementName) {
                $path[] = $containerKey;
                return $container;
            } elseif (isset($container['childs'])) {
                $subPath = [];
                $result = $this->findElementPath($container['childs'], $elementName, $subPath);
                if ($result !== null) {
                    $path[] = $containerKey;
                    $path = array_merge($path, $subPath);
                    return $result;
                }
            }
        }
        return null;
    }

    /**
     * @param $keys
     * @param $elementName
     * @param $element
     */
    public function addElement($keys, $elementName, $element)
    {
        $nestedElement = &$this->elements;
        foreach ($keys as $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            $nestedElement = &$nestedElement[$key]['childs'];
        }
        // $nestedContainer is the parentContainer childs
        if($nestedElement && (isset($element['before']) || isset($element['after']))) {
            if(isset($element['before'])) {
                $this->addElementWithPriority($elementName, $element, $nestedElement, 'before');
            } else if(isset($element['after'])) {
                $this->addElementWithPriority($elementName, $element, $nestedElement, 'after');
            }
        }else {
            $nestedElement[$elementName] = $element;
        }

        unset($nestedElement);
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
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
     * @return \ProgramCms\ThemeBundle\Model\PageLayout
     */
    public function getPageLayout(): \ProgramCms\ThemeBundle\Model\PageLayout
    {
        return $this->pageLayout;
    }

    /**
     * Helper method to set title from configuration
     * @param $title
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
     * Render Block Element
     * @param $block
     * @return string
     * @throws \ReflectionException
     */
    private function renderBlock($block): string
    {
        // Get Block instance from Container class
        $blockClassInstance = $this->objectManager->create($block['class']);
        if(isset($block['arguments'])) {
            $blockClassInstance->setData($block['arguments']);
        }
        if(isset($block['childs'])) {
            foreach($block['childs'] as $childBlockName => $childBlock) {
                $childBlockClassInstance = $this->objectManager->create($childBlock['class']);
                if(isset($childBlock['arguments'])) {
                    $childBlockClassInstance->setData($childBlock['arguments']);
                }
                if(isset($childBlock['template'])) {
                    $childBlockClassInstance->setTemplate($childBlock['template']);
                }
                $blockClassInstance->addChildBlock($childBlockName, $childBlockClassInstance);
            }
        }

        if(isset($block['template'])) {
            $blockClassInstance->setTemplate($block['template']);
        }

        return $blockClassInstance->toHtml();
    }

    /**
     * Parses Tag Nodes Tree and creates final body content
     * @return string
     */
    public function renderPage($container = null): string
    {
        if($container === null) {
            $container = $this->elements;
        }

        $this->cleanUnusedPageLayoutContainers();

        $pageContent = '';
        foreach($container as $containerNode) {
            if($containerNode && $containerNode['type'] == 'container') {
                // Render only containers with sub-elements
                if(isset($containerNode['childs']) && count($containerNode['childs'])) {
                    if (isset($containerNode['htmlTag'])) {
                        // Renderable container case, prepares & adds Html Elements
                        $htmlClass = isset($containerNode['htmlClass']) ? 'class="' . $containerNode['htmlClass'] . '"' : '';
                        $pageContent .= "<" . $containerNode['htmlTag'] . " " . $htmlClass . ">";
                    }
                    // Render internal elements if exists
                    $pageContent .= $this->renderPage($containerNode['childs']);

                    if (isset($containerNode['htmlTag'])) {
                        $pageContent .= "</" . $containerNode['htmlTag'] . ">";
                    }
                }
            }else if($containerNode && $containerNode['type'] == 'block') {
                $pageContent .= $this->renderBlock($containerNode);
            }
        }

        return $pageContent;
    }

    /**
     * Clean Unused Page Layout containers in the elements tree
     */
    private function cleanUnusedPageLayoutContainers()
    {
        // Clean unneeded Page Layout containers
        foreach($this->elementsWithFileName as $layoutFileName => $layout) {
            if($layoutFileName != $this->currentPageLayout && isset($layout['handlers']) && !in_array($layoutFileName, $layout['handlers'])) {
                foreach($layout as $layoutKey => $layoutContainerName) {
                    if(!is_array($layoutContainerName) && $layoutKey != 'handlers') {
                        $this->removeElement($layoutContainerName);
                    }
                }
            }
        }
    }

    /**
     * Create an instance of Block and returns it
     * @param $blockClass
     * @param string $name
     * @param array $arguments
     * @return object|null
     */
    public function _createBlock($blockClass, string $name, array $arguments = []): ?object
    {
        // Get Block instance from Container class
        $blockClassInstance = $this->objectManager->create($blockClass);
        if(isset($arguments['arguments'])) {
            $blockClassInstance->setData($arguments['arguments']);
        }
        if(isset($arguments['template'])) {
            $blockClassInstance->setTemplate($arguments['template']);
        }
        $this->setBlock($name, $blockClassInstance);
        return $blockClassInstance;
    }

    /**
     * Get Block instance by name
     * @param string $name
     * @return false|mixed
     */
    public function getBlock(string $name)
    {
        return $this->blocks[$name] ?? false;
    }

    public function getChildBlock(string $parentName, string $alias)
    {

    }

    public function setChild(string $parentName, string $elementName, string $alias)
    {

    }

    public function getChildNames(string $parentName)
    {

    }

    /**
     * Get all Blocks instances
     * @return array
     */
    public function getAllBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * Get ChildBlocks as a List of Objects
     * @param string $parentName
     */
    public function getChildBlocks(string $parentName)
    {

    }

    public function getParentName(string $childName)
    {

    }

    /**
     * @param $name
     * @param $block
     * @return $this
     */
    public function setBlock($name, $block)
    {
        $this->blocks[$name] = $block;
        return $this;
    }

    public function createBlock($type, string $name = '', array $arguments = [])
    {

    }
}