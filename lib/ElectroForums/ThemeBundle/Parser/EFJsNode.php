<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFJsNode extends \Twig\Node\Node
{
    public function __construct($jsFiles, $lineno, $tag = null)
    {
        parent::__construct([], ['js_files' => $jsFiles], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $jsFiles = implode(',', $this->getAttribute('js_files'));
        $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->addEFJs('$jsFiles');");
    }
}