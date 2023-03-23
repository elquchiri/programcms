<?php


namespace ElectroForums\ThemeBundle\Twig;


class EFThemeExtension extends \Twig\Extension\AbstractExtension
{
    protected \Twig\Environment $environment;
    protected \ElectroForums\ThemeBundle\Model\PageLayout $pageLayout;

    private $efPageLayouts = [];
    private $efPageLayoutNumber = 0;
    public $efContainers;
    private $efBlocks = [];
    private $efCss = [];
    private $efJs = [];

    public function __construct(
        \Twig\Environment $environment,
        \ElectroForums\ThemeBundle\Model\PageLayout $pageLayout
    )
    {
        $this->environment = $environment;
        $this->efContainers = [];
        $this->pageLayout = $pageLayout;
    }

    public function addReferenceContainer($containerName, $blockName)
    {
        if(!isset($this->efContainers[$containerName])) {
            throw new \Exception(sprintf("Unable to find EfContainer %s", $containerName));
        }

        //$this->efContainers[$containerName]['blocks'][] = $blockName;
    }

    public function addEfBlock($blockName, $blockClass, $blockTemplate)
    {
        //$this->efBlocks[$blockName] = $this->renderEfBlock($blockClass, $blockTemplate);
    }

    /**
     * @return array
     */
    public function getEfBlocks(): array
    {
        return $this->efBlocks;
    }

    public function addEfRootContainer($containerName)
    {
        if(!count($this->efContainers)) {
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

            if($targetContainer) {
                $this->addContainerElement($containerPaths, $containerName, [
                    'containers' => [],
                    'blocks' => [],
                    'htmlTag' => $containerHtmlTag,
                    'htmlClass' => $containerHtmlClass
                ]);
            }else{
                // Throws Exception if EFContainer's parent not found
                throw new \Exception(sprintf("Cant insert %s, EFContainer's parent \"%s\" not found.", $containerName, $containerParent));
            }
    }

    public function findContainerPath($efContainers, $containerName, &$path = [])
    {
        foreach($efContainers as $containerKey => $container) {
            if($containerKey == $containerName) {
                $path[] = $containerKey;
                return $container;
            }elseif (isset($container['containers'])) {
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

    public function getEfContainers(): array
    {
        return $this->efContainers;
    }

    public function addEFPageLayout($pageLayoutName)
    {
        if($pageLayoutName) {
            $this->efPageLayouts[] = $pageLayoutName;
        }
    }

    public function getEFPageLayouts()
    {
        return $this->efPageLayouts;
    }

    public function canAddPageLayout($pageLayout): bool
    {
        if(empty($pageLayout)) {
            return false;
        }
        $pageLayoutNumber = substr($pageLayout, 0, 1);

        if($this->efPageLayoutNumber < $pageLayoutNumber) {
            $this->efPageLayoutNumber = $pageLayoutNumber;

            return true;
        }
        return false;
    }

    public function addEFCss($cssTags)
    {
        foreach(explode(',', $cssTags) as $css) {
            if(!empty($css) || $css != '') {
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
        foreach(explode(',', $jsTags) as $js) {
            if(!empty($js) || $js != '') {
                $this->efJs[] = $js;
            }
        }
    }

    public function getEFJs(): array
    {
        return $this->efJs;
    }

    private function renderEfBlock($blockClass, $blockTemplate): string
    {
        $blockClassReflection = new \ReflectionClass($blockClass);
        $blockClass = $blockClassReflection->newInstance();

        return $this->environment->render($blockTemplate, ['efBlock' => $blockClass]);
    }

    public function getPageLayout()
    {
        return $this->pageLayout;
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