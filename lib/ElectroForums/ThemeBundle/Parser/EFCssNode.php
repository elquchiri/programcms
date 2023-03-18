<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFCssNode extends \Twig\Node\Node
{
    public function __construct($cssFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['css_files' => $cssFiles], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $cssFiles = implode(',', $this->getAttribute('css_files'));
        $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->addEFCss('$cssFiles');");
    }
}