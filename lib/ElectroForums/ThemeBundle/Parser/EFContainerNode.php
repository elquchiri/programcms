<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFContainerNode extends \Twig\Node\Node
{
    public function __construct($containerName, $containerHtmlTag, $containerHtmlClass, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName, 'containerHtmlTag' => $containerHtmlTag, 'containerHtmlClass' => $containerHtmlClass], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');
        $containerHtmlTag = $this->getAttribute('containerHtmlTag');
        $containerHtmlClass = $this->getAttribute('containerHtmlClass');

        $compiler
            ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->addEfContainer('$containerName', '$containerHtmlTag', '$containerHtmlClass');");

        foreach($this->getNode('body') as $node) {
            if($node instanceof \ElectroForums\ThemeBundle\Parser\EFBlockNode) {
                $blockName = $node->getAttribute('blockName');
                $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->addReferenceContainer('$containerName', '$blockName');");
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}