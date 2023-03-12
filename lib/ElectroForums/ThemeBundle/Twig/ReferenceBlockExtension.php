<?php


namespace ElectroForums\ThemeBundle\Twig;


class ReferenceBlockExtension extends \Twig\Extension\AbstractExtension
{
    protected \Twig\Environment $environment;

    private $referenceContainers = [];
    private $efBlocks = [];

    public function __construct(\Twig\Environment $environment)
    {
        $this->environment = $environment;
    }

    public function addReferenceContainer($containerName, array $block)
    {
        $this->referenceContainers[$containerName][] = $block;
    }

    public function getReferenceContainers()
    {
        return $this->referenceContainers;
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

    public function getTokenParsers()
    {
        return [
            new \ElectroForums\ThemeBundle\Parser\EFBlockTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFReferenceContainerTokenParser(),
            new \ElectroForums\ThemeBundle\Parser\EFLayoutTokenParser()
        ];
    }

    private function renderEfBlock($blockClass, $blockTemplate): string
    {
        $blockClassReflection = new \ReflectionClass($blockClass);
        $blockClass = $blockClassReflection->newInstance();

        return $this->environment->render($blockTemplate, ['efBlock' => $blockClass]);
    }
}