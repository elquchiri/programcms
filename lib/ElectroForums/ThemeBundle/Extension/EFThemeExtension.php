<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Extension;


use Twig\Source;

class EFThemeExtension extends \Twig\Extension\AbstractExtension
{
    protected \Twig\Environment $environment;
    protected \ElectroForums\ThemeBundle\Model\PageLayout $pageLayout;
    /**
     * Saves Page Layouts
     * @var array
     */
    private array $efPageLayouts = [];
    /**
     * Holds elements Tree with All tags
     * @var array
     */
    public array $efContainers;
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

    public function __construct(
        \Twig\Environment $environment,
        \ElectroForums\ThemeBundle\Model\PageLayout $pageLayout
    )
    {
        $this->environment = $environment;
        $this->efContainers = [];
        $this->pageLayout = $pageLayout;
    }

    /**
     * @throws \Exception
     */
    public function addEfBlock($blockName, $blockClass, $blockTemplate, $containerParent, $before = null, $after = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->efContainers, $containerParent, $containerPaths);

        if ($targetContainer) {
            $element = [
                'type' => 'block',
                'class' => $blockClass,
                'template' => $blockTemplate
            ];
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

    public function addEfChildrenBlock($blockName, $blockClass, $blockTemplate, $blockParent)
    {
        $blockPaths = [];
        $targetBlock = $this->findBlockPath($this->efContainers, $blockParent, $blockPaths);

        if ($targetBlock) {
            $this->addChildrenBlockElement($blockPaths, $blockName, [
                'class' => $blockClass,
                'template' => $blockTemplate
            ]);
        } else {
            // Throws Exception if EFContainer's parent not found
            throw new \Exception(sprintf("Cant insert %s, EFBlock's parent \"%s\" not found.", $blockParent));
        }
    }

    public function addEfRootContainer($containerName)
    {
        if (!count($this->efContainers)) {
            $this->efContainers[$containerName] = [
                'type' => 'container'
            ];
        }
    }

    /**
     * @throws \Exception
     */
    public function addEfContainer($containerName, $containerParent = null, $containerHtmlTag = null, $containerHtmlClass = null, $before = null, $after = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->efContainers, $containerParent, $containerPaths);

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
     * Remove element from Tree
     * @param $name
     */
    public function removeElement($name)
    {
        $containerPaths = [];
        $targetContainer = $this->findElementPath($this->efContainers, $name, $containerPaths);
        if ($targetContainer) {
            $nestedContainer = &$this->efContainers;
            foreach ($containerPaths as $index => $key) {
                // Update $nestedContainer to point to the nested array corresponding to the current key
                if($index < count($containerPaths) - 1) {
                    $nestedContainer = &$nestedContainer[$key]['childs'];
                }else{
                    $nestedContainer = &$nestedContainer[$key];
                }
            }
            $nestedContainer = NULL;
        }
    }

    public function findElementPath($efContainers, $containerName, &$path = [])
    {
        foreach ($efContainers as $containerKey => $container) {
            if ($containerKey == $containerName) {
                $path[] = $containerKey;
                return $container;
            } elseif (isset($container['childs'])) {
                $subPath = [];
                $result = $this->findElementPath($container['childs'], $containerName, $subPath);
                if ($result !== null) {
                    $path[] = $containerKey;
                    $path = array_merge($path, $subPath);
                    return $result;
                }
            }
        }
        return null;
    }

    private function findBlockInsideContainer($blockTarget, $blocks, &$path)
    {
        foreach ($blocks as $blockKey => $block) {
            if ($blockKey == $blockTarget) {
                $path[] = $blockKey;
                return $blockKey;
            } else if (isset($block['childs'])) {
                $subPath = [];
                $result = $this->findBlockInsideContainer($blockTarget, $block['childs'], $subPath);
                if ($result !== null) {
                    $path[] = $blockKey;
                    $path = array_merge($path, $subPath);
                    return $result;
                }
            }
        }
        return null;
    }

    public function findBlockPath($efContainers, $blockParent, &$path = [])
    {
        foreach ($efContainers as $containerKey => $container) {
            $blocksPath = [];
            $targetBlock = $this->findBlockInsideContainer($blockParent, $container['childs'], $blocksPath);
            if($targetBlock) {
                $path[] = $containerKey;
                $path['childs'] = $blocksPath;
                return $container;
            }else if (isset($container['childs'])) {
                $subPath = [];
                $result = $this->findBlockPath($container['childs'], $blockParent, $subPath);
                if ($result !== null) {
                    $path[] = $containerKey;
                    $path = array_merge($path, $subPath);
                    return $result;
                }
            }
        }
        return null;
    }

    public function addElement($keys, $elementName, $element)
    {
        $nestedContainer = &$this->efContainers;
        foreach ($keys as $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            $nestedContainer = &$nestedContainer[$key]['childs'];
        }
        // $nestedContainer is the parentContainer childs
        if($nestedContainer && (isset($element['before']) || isset($element['after']))) {
            if(isset($element['before'])) {
                $this->checkForPriority($elementName, $element, $nestedContainer, 'before');
            }
            if(isset($element['after'])) {
                $this->checkForPriority($elementName, $element, $nestedContainer, 'after');
            }
        }else {
            $nestedContainer[$elementName] = $element;
        }

        unset($nestedContainer);
    }

    protected function checkForPriority($containerName, $container, &$nestedContainer, $priority)
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

    public function addChildrenBlockElement($blockPaths, $blockName, $blockParams)
    {
        $nestedContainer = &$this->efContainers;
        foreach ($blockPaths as $index => $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            if(!is_array($key)) {
                $nestedContainer = &$nestedContainer[$key]['childs'];
            }
        }

        foreach($blockPaths['childs'] as $blockKey) {
            $nestedContainer = &$nestedContainer[$blockKey]['childs'];
        }

        $nestedContainer[$blockName] = [
            'type'      => 'block',
            'class'     => $blockParams['class'],
            'template'  => $blockParams['template']
        ];

        unset($nestedContainer);
    }

    public function getEfContainers(): array
    {
        return $this->efContainers;
    }

    public function addEFPageLayout($pageLayoutName)
    {
        if ($pageLayoutName) {
            $this->efPageLayouts[$pageLayoutName] = $pageLayoutName;
        }
    }

    public function getEFPageLayouts(): array
    {
        return $this->efPageLayouts;
    }

    public function canAddPageLayout($pageLayout): bool
    {
        return !isset($this->efPageLayouts[$pageLayout]);
    }

    public function addEFCss($cssTags)
    {
        foreach (explode(',', $cssTags) as $css) {
            if (!empty($css) || $css != '') {
                $this->efCss[] = $css;
            }
        }
    }

    public function getEFCss(): array
    {
        return $this->efCss;
    }

    public function addEFJs($jsTags)
    {
        foreach (explode(',', $jsTags) as $js) {
            if (!empty($js) || $js != '') {
                $this->efJs[] = $js;
            }
        }
    }

    public function getEFJs(): array
    {
        return $this->efJs;
    }

    private function renderEfBlock($block): string
    {
        $blockClassReflection = new \ReflectionClass($block['class']);
        $blockClassInstance = $blockClassReflection->newInstance($this->environment);

        if(isset($block['childs'])) {
            $blockClassInstance->setChildBlocks($block['childs']);
        }

        return $blockClassInstance
            ->setTemplate($block['template'])
            ->assign(['efBlock' => $blockClassInstance])
            ->toHtml();
    }

    public function getPageLayout(): \ElectroForums\ThemeBundle\Model\PageLayout
    {
        return $this->pageLayout;
    }

    public function setEfTitle($title)
    {
        $this->efTitle = $title;
    }

    public function getEfTitle(): string
    {
        return $this->efTitle ?? 'Welcome !';
    }

    /**
     * Parses Tag Nodes Tree and creates final body content
     * @return string
     */
    public function renderPage($container = null): string
    {
        if($container === null) {
            $container = $this->efContainers;
        }

        // Clean unneeded Page Layout containers
//        foreach($this->efPageLayouts as $efPageLayout) {
//            $pageLayoutContents = $efExtension->getPageLayout()->getPageLayoutContents($pageLayoutName);
//            $source = new Source($pageLayoutContents, 'PageLayout');
//            $nodes = $this->environment->parse($this->environment->tokenize($source));
//        }

        $pageContent = '';
        foreach($container as $containerNode) {
            if($containerNode['type'] == 'container') {
                if(isset($containerNode['htmlTag'])) {
                    // Renderable container case, prepares & adds Html Elements
                    $htmlClass = isset($containerNode['htmlClass']) ? 'class="' . $containerNode['htmlClass'] . '"' : '';
                    $pageContent .= "<" . $containerNode['htmlTag'] . " " . $htmlClass . ">";
                }
                // Render internal elements if exists
                if(isset($containerNode['childs']) && count($containerNode['childs'])) {
                    $pageContent .= $this->renderPage($containerNode['childs']);
                }
                if(isset($containerNode['htmlTag'])) {
                    $pageContent .= "</". $containerNode['htmlTag'] .">";
                }
            }else if($containerNode['type'] == 'block') {
                $pageContent .= $this->renderEfBlock($containerNode);
            }
        }

        return $pageContent;
    }

    /**
     * Defines All ElectroForums's Twig Token Parsers
     * @return array
     */
    public function getTokenParsers()
    {
        return [
            new \ElectroForums\ThemeBundle\Parser\EFLayoutStarterTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFPageTokenParser($this->environment),
            new \ElectroForums\ThemeBundle\Parser\EFUpdateTokenParser($this->environment),
            new \ElectroForums\ThemeBundle\Parser\EFLayoutTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFTitleTokenParser($this->environment),
            new \ElectroForums\ThemeBundle\Parser\EFContainerTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFBlockTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFReferenceBlockTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFCssTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFJsTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFReferenceContainerTokenParser()
        ];
    }

    public function getNodeVisitors(): array
    {
        return [
            new \ElectroForums\ThemeBundle\NodeVisitor\PageNodeVisitor()
        ];
    }
}