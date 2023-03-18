<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFPageNode extends \Twig\Node\Node
{
    public function __construct($pageLayoutName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['pageLayoutName' => $pageLayoutName], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $pageLayoutName = $this->getAttribute('pageLayoutName');
        $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->addEFPageLayout('$pageLayoutName');");

        $compiler->subcompile($this->getNode('body'));
    }
}