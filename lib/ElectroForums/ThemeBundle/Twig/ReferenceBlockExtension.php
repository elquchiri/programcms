<?php


namespace ElectroForums\ThemeBundle\Twig;


class ReferenceBlockExtension extends \Twig\Extension\AbstractExtension
{
    protected \Twig\Environment $environment;

    private $efPageLayout;
    private $efContainers = [];
    private $efBlocks = [];
    private $efCss = [];
    private $efJs = [];

    public function __construct(\Twig\Environment $environment)
    {
        $this->environment = $environment;
    }

    public function addReferenceContainer($containerName, $blockName)
    {
        if(!isset($this->efContainers[$containerName])) {
            throw new \Exception(sprintf("Unable to find EfContainer %s", $containerName));
        }

        $this->efContainers[$containerName]['blocks'][] = $blockName;
    }

    public function addEfBlock($blockName, $blockClass, $blockTemplate)
    {
        $this->efBlocks[$blockName] = $this->renderEfBlock($blockClass, $blockTemplate);
    }

    /**
     * @return array
     */
    public function getEfBlocks(): array
    {
        return $this->efBlocks;
    }

    public function addEfContainer($containerName, $containerHtmlTag, $containerHtmlClass)
    {
        $this->efContainers[$containerName] = [
            'blocks' => [],
            'htmlTag' => $containerHtmlTag,
            'htmlClass' => $containerHtmlClass
        ];
    }

    public function getEfContainers(): array
    {
        return $this->efContainers;
    }

    public function addEFPageLayout($pageLayoutName)
    {
        if($pageLayoutName) {
            $this->efPageLayout = $pageLayoutName;
        }
    }

    public function getEFPageLayout()
    {
        return $this->efPageLayout;
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

    public function getTokenParsers()
    {
        return [
            new \ElectroForums\ThemeBundle\Parser\EFBlockTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFReferenceContainerTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFLayoutStarterTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFContainerTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFPageTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFCssTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFJsTokenParser()
        ];
    }
}