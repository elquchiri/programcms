<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFReferenceContainerNode extends \Twig\Node\Node
{
    public function __construct($containerName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');
        foreach($this->getNode('body') as $node) {
            if($node instanceof \ElectroForums\ThemeBundle\Parser\EFBlockNode) {
                $blockName = $node->getAttribute('blockName');
                $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->addReferenceContainer('$containerName', '$blockName');");
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}