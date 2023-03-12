<?php


namespace ElectroForums\ThemeBundle\Twig;


class ReferenceBlockExtension extends \Twig\Extension\AbstractExtension
{
    protected \Twig\Environment $environment;

    private $efContainers = [];
    private $efBlocks = [];

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

    public function getEfContainers()
    {
        return $this->efContainers;
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
            new \ElectroForums\ThemeBundle\Parser\EFLayoutTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFContainerTokenParser()
        ];
    }
}