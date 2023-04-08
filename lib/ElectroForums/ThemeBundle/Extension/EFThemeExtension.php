<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Extension;


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
     * Used to check page layout Inheritance
     * @var int
     */
    private int $efPageLayoutNumber = 0;
    /**
     * Holds All tags
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
    public function addEfBlock($blockName, $blockClass, $blockTemplate, $containerParent)
    {
        $containerPaths = [];
        $targetContainer = $this->findContainerPath($this->efContainers, $containerParent, $containerPaths);

        if ($targetContainer) {
            $this->addBlockElement($containerPaths, $blockName, [
                'class' => $blockClass,
                'template' => $blockTemplate
            ]);
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
            throw new \Exception(sprintf("Cant insert %s, EFBlock's parent \"%s\" not found.", $blockName, $containerParent));
        }
    }

    public function addEfRootContainer($containerName)
    {
        if (!count($this->efContainers)) {
            $this->efContainers[$containerName] = [
                'containers' => [],
                'blocks' => []
            ];
        }
    }

    /**
     * @throws \Exception
     */
    public function addEfContainer($containerName, $containerParent = null, $containerHtmlTag = null, $containerHtmlClass = null)
    {
        $containerPaths = [];
        $targetContainer = $this->findContainerPath($this->efContainers, $containerParent, $containerPaths);

        if ($targetContainer) {
            $container = [
                'containers' => [],
                'blocks' => []
            ];
            if(!empty($containerHtmlTag)) {
                $container['htmlTag'] = $containerHtmlTag;
            }
            if(!empty($containerHtmlClass)) {
                $container['htmlClass'] = $containerHtmlClass;
            }
            $this->addContainerElement($containerPaths, $containerName, $container);
        } else {
            // Throws Exception if EFContainer's parent not found
            throw new \Exception(sprintf("Cant insert %s, EFContainer's parent \"%s\" not found.", $containerName, $containerParent));
        }
    }

    public function findContainerPath($efContainers, $containerName, &$path = [])
    {
        foreach ($efContainers as $containerKey => $container) {
            if ($containerKey == $containerName) {
                $path[] = $containerKey;
                return $container;
            } elseif (isset($container['containers'])) {
                $subPath = [];
                $result = $this->findContainerPath($container['containers'], $containerName, $subPath);
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
            } else if (isset($block['blocks'])) {
                $subPath = [];
                $result = $this->findBlockInsideContainer($blockTarget, $block['blocks'], $subPath);
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
            $targetBlock = $this->findBlockInsideContainer($blockParent, $container['blocks'], $blocksPath);
            if($targetBlock) {
                $path[] = $containerKey;
                $path['blocks'] = $blocksPath;
                return $container;
            }else if (isset($container['containers'])) {
                $subPath = [];
                $result = $this->findBlockPath($container['containers'], $blockParent, $subPath);
                if ($result !== null) {
                    $path[] = $containerKey;
                    $path = array_merge($path, $subPath);
                    return $result;
                }
            }
        }
        return null;
    }

    public function addContainerElement($keys, $containerName, $container)
    {
        $nestedContainer = &$this->efContainers;
        foreach ($keys as $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            $nestedContainer = &$nestedContainer[$key]['containers'];
        }

        $nestedContainer[$containerName] = $container;

        unset($nestedContainer);
    }

    /**
     * Cross block target keys to insert a new EFBlock
     * @param $keys
     * @param $blockName
     * @param $block
     */
    public function addBlockElement($keys, $blockName, $block)
    {
        $nestedContainer = &$this->efContainers;
        foreach ($keys as $index => $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            if($index == count($keys) - 1) {
                $nestedContainer = &$nestedContainer[$key]['blocks'];
            }else{
                $nestedContainer = &$nestedContainer[$key]['containers'];
            }
        }

        // Block is an array for eventual subBlocks
        $nestedContainer[$blockName] = [
            'class'     => $block['class'],
            'template'  => $block['template']
        ];

        unset($nestedContainer);
    }

    public function addChildrenBlockElement($blockPaths, $blockName, $blockParams)
    {
        $nestedContainer = &$this->efContainers;
        foreach ($blockPaths as $index => $key) {
            // Update $nestedContainer to point to the nested array corresponding to the current key
            if(!is_array($key)) {
                // Blocks section
                if($index == count($blockPaths) - 2) {
                    $nestedContainer = &$nestedContainer[$key]['blocks'];
                }else {
                    // Containers section
                    $nestedContainer = &$nestedContainer[$key]['containers'];
                }
            }
        }

        foreach($blockPaths['blocks'] as $blockKey) {
            $nestedContainer = &$nestedContainer[$blockKey]['blocks'];
        }

        $nestedContainer[$blockName] = [
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
            $this->efPageLayouts[] = $pageLayoutName;
        }
    }

    public function getEFPageLayouts(): array
    {
        return $this->efPageLayouts;
    }

    public function canAddPageLayout($pageLayout): bool
    {
        if (empty($pageLayout)) {
            return false;
        }
        $pageLayoutNumber = substr($pageLayout, 0, 1);

        if ($this->efPageLayoutNumber < $pageLayoutNumber) {
            $this->efPageLayoutNumber = $pageLayoutNumber;

            return true;
        }
        return false;
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

        if(isset($block['blocks'])) {
            $blockClassInstance->setChildBlocks($block['blocks']);
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

        $pageContent = '';
        foreach($container as $containerNode) {
            if(isset($containerNode['htmlTag'])) {
                // Renderable container case, prepares & adds Html Elements
                $htmlClass = isset($containerNode['htmlClass']) ? 'class="'. $containerNode['htmlClass'] .'"' : '';
                $pageContent .= "<". $containerNode['htmlTag'] ." ". $htmlClass .">";

                // Render internal Blocks if exists
                if(isset($containerNode['blocks']) && count($containerNode['blocks'])) {
                    $pageContent .= $this->renderContainerBlocks($containerNode['blocks']);
                }
                // Render internal Containers if exists
                if(isset($containerNode['containers']) && count($containerNode['containers'])) {
                    $pageContent .= $this->renderPage($containerNode['containers']);
                }

                $pageContent .= "</". $containerNode['htmlTag'] .">";
            }else{
                // Render internal Blocks if exists
                if(isset($containerNode['blocks']) && count($containerNode['blocks'])) {
                    $pageContent .= $this->renderContainerBlocks($containerNode['blocks']);
                }
                if(isset($containerNode['containers'])) {
                    $pageContent .= $this->renderPage($containerNode['containers']);
                }
            }
        }

        return $pageContent;
    }

    protected function renderContainerBlocks($blocks): string
    {
        $containerBlocksContent = '';
        foreach($blocks as $block) {
            $containerBlocksContent .= $this->renderEfBlock($block);
        }
        return $containerBlocksContent;
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