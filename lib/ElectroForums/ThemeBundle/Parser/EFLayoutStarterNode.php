<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFLayoutStarterNode extends \Twig\Node\Node
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        // We can also use ob_start() and ob_get_clean() with a $compiler->write("\n") to buffer output
        $compiler->subcompile($this->getNode('body'))
            ->write("\$efCss = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfCss();")
            ->write("\$efJs = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfJs();")
            ->write("\$efContainers = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfContainers();")
            ->write("\$efBlocks = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfBlocks();")
            ->write("echo \$this->env->render('@ElectroForumsTheme/base.html.twig', ['efCss' => \$efCss, 'efJs' => \$efJs, 'efContainers' => \$efContainers, 'efBlocks' => \$efBlocks]);");
    }
}