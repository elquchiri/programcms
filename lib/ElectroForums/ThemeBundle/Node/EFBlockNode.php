<?php


namespace ElectroForums\ThemeBundle\Node;


class EFBlockNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($blockName, $blockClass, $blockTemplate, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['blockName' => $blockName, 'blockClass' => $blockClass, 'blockTemplate' => $blockTemplate], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $blockName = $this->getAttribute('blockName');
        $blockTemplate = $this->getAttribute('blockTemplate');
        $blockClass = $this->getAttribute('blockClass');

        $compiler
            ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->addEfBlock('$blockName', '$blockClass', '$blockTemplate');");

        // TODO: Subcompile to continue processing childBlocks if any
        $compiler->subcompile($this->getNode('body'));
    }
}