<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Extension;

/**
 * Class EFThemeExtension
 * @package ProgramCms\ThemeBundle\Extension
 */
class EFThemeExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * @var \ProgramCms\CoreBundle\Model\Utils\BundleManager
     */
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    /**
     * @var \Twig\Environment
     */
    private \Twig\Environment $environment;
    /**
     * PageLayout Model, used to get page layout content
     * @var \ProgramCms\ThemeBundle\Model\PageLayout
     */
    private \ProgramCms\ThemeBundle\Model\PageLayout $pageLayout;
    /**
     * Saves Page Layouts
     * @var array
     */
    private array $efPageLayouts = [];
    /**
     * Stores the last page layout, current page
     * @var string
     */
    private string $currentPageLayout;
    /**
     * Holds elements Tree with All tags
     * @var array
     */
    private array $efElements;
    /**
     * Holds All Css files
     * @var array
     */
    private array $efCss = [];
    /**
     * Holds All Js files
     * @var array
     */
    private array $efJs = [];
    /**
     * Page title content
     * @var
     */
    private string $efTitle;
    /**
     * Used to remove unused containers by keeping only those of the last layout
     * @var array
     */
    private array $elementsWithFileName;

    public function __construct(
        \Twig\Environment $environment,
        \ProgramCms\ThemeBundle\Model\PageLayout $pageLayout,
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
    )
    {
        $this->environment = $environment;
        $this->bundleManager = $bundleManager;
        $this->efElements = [];
        $this->pageLayout = $pageLayout;
        $this->elementsWithFileName = [];
        $this->currentPageLayout = "";
    }

    /**
     * @param $containerName
     */
    public function addEfRootContainer($containerName)
    {
        if (!count($this->efElements)) {
            $this->efElements[$containerName] = [
                'type' => 'container'
            ];
        }
    }
    /**
     * @throws \Exception
     */
    public function addEfBlock($blockName, $blockClass, $blockTemplate, $containerParent, $before = null, $after = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->efElements, $containerParent, $containerPaths);

        if ($targetContainer) {
            $element = [
                'type' => 'block',
                'class' => $blockClass,
                'template' => ''
            ];

            if(!empty($blockTemplate)) {
                $element['template'] = $blockTemplate;
            }

            if(!empty($before)) {
                $element['before'] = $before;
            }
            if(!empty($after)) {
                $element['after'] = $after;
            }
            $this->addElement($containerPaths, $blockName, $element);
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
        $nestedContainer = &$this->efElements;
        $path = [];
        $targetContainer = $this->findElementPath($this->efElements, $blockName, $path);

        if($targetContainer) {
            foreach ($path as $index => $key) {
                // Update $nestedContainer to point to the nested array corresponding to the current key
                if ($index < count($path) - 1) {
                    $nestedContainer = &$nestedContainer[$key]['childs'];
                } else {
                    $nestedContainer = &$nestedContainer[$key];
                }
            }
            $nestedContainer['arguments'] = json_decode($arguments, true);
        }
    }

    /**
     * @throws \Exception
     */
    public function addEfContainer($containerName, $containerParent = null, $containerHtmlTag = null, $containerHtmlClass = null, $before = null, $after = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->efElements, $containerParent, $containerPaths);

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
        $element = &$this->efElements;

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
        $this->findElementPath($this->efElements, $targetElementName, $targetElementPath);

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
        $targetContainer = $this->findElementPath($this->efElements, $name, $containerPaths);
        if ($targetContainer) {
            $nestedContainer = &$this->efElements;
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
        $nestedContainer = &$this->efElements;
        foreach ($keys as $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            $nestedContainer = &$nestedContainer[$key]['childs'];
        }
        // $nestedContainer is the parentContainer childs
        if($nestedContainer && (isset($element['before']) || isset($element['after']))) {
            if(isset($element['before'])) {
                $this->addElementWithPriority($elementName, $element, $nestedContainer, 'before');
            } else if(isset($element['after'])) {
                $this->addElementWithPriority($elementName, $element, $nestedContainer, 'after');
            }
        }else {
            $nestedContainer[$elementName] = $element;
        }

        unset($nestedContainer);
    }

    /**
     * @return array
     */
    public function getEfContainers(): array
    {
        return $this->efElements;
    }

    /**
     * @param $pageLayoutName
     */
    public function addEFPageLayout($pageLayoutName)
    {
        if ($pageLayoutName) {
            $this->efPageLayouts[$pageLayoutName] = $pageLayoutName;
        }
    }

    /**
     * @return array
     */
    public function getEFPageLayouts(): array
    {
        return $this->efPageLayouts;
    }

    /**
     * @param $pageLayout
     * @return bool
     */
    public function canAddPageLayout($pageLayout): bool
    {
        return !isset($this->efPageLayouts[$pageLayout]);
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
    public function addEFCss($cssTags)
    {
        foreach (explode(',', $cssTags) as $css) {
            if (!empty($css) || $css != '') {
                $this->efCss[] = $css;
            }
        }
    }

    /**
     * @return array
     */
    public function getEFCss(): array
    {
        return $this->efCss;
    }

    /**
     * @param $jsTags
     */
    public function addEFJs($jsTags)
    {
        foreach (explode(',', $jsTags) as $js) {
            if (!empty($js) || $js != '') {
                $this->efJs[] = $js;
            }
        }
    }

    /**
     * @return array
     */
    public function getEFJs(): array
    {
        return $this->efJs;
    }

    /**
     * @return \ProgramCms\ThemeBundle\Model\PageLayout
     */
    public function getPageLayout(): \ProgramCms\ThemeBundle\Model\PageLayout
    {
        return $this->pageLayout;
    }

    /**
     * @param $title
     */
    public function setEfTitle($title)
    {
        $this->efTitle = $title;
    }

    /**
     * @return string
     */
    public function getEfTitle(): string
    {
        return $this->efTitle ?? 'Welcome !';
    }

    /**
     * Render EFBlocks Elements
     * @param $block
     * @return string
     * @throws \ReflectionException
     */
    private function renderEfBlock($block): string
    {
        // Get Block instance from Container class
        $blockClassInstance = $this->bundleManager->getContainer()->get($block['class']);

        if(isset($block['arguments'])) {
            $blockClassInstance->setData($block['arguments']);
        }
        if(isset($block['childs'])) {
            foreach($block['childs'] as $childBlockName => $childBlock) {
                $childBlockClassInstance = $this->bundleManager->getContainer()->get($childBlock['class']);
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
            $container = $this->efElements;
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
                $pageContent .= $this->renderEfBlock($containerNode);
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
     * Defines All ProgramCms's Twig Token Parsers
     * @return array
     */
    public function getTokenParsers()
    {
        return [
            new \ProgramCms\ThemeBundle\Parser\EFLayoutStarterTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFPageTokenParser($this->environment),
            new \ProgramCms\ThemeBundle\Parser\EFUpdateTokenParser($this->environment),
            new \ProgramCms\ThemeBundle\Parser\EFLayoutTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFTitleTokenParser($this->environment),
            new \ProgramCms\ThemeBundle\Parser\EFContainerTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFBlockTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\Argument\ArgumentsTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\Argument\ArgumentTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFReferenceBlockTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFCssTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFJsTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFMoveTokenParser(),
            new \ProgramCms\ThemeBundle\Parser\EFReferenceContainerTokenParser()
        ];
    }
}