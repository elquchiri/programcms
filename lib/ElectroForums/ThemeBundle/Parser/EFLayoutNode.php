<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFLayoutNode extends \Twig\Node\Node
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        // We can also use ob_start() and ob_get_clean() with a $compiler->write("\n") to buffer output
        $compiler->subcompile($this->getNode('body'))
            ->write("\$referenceContainers = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getReferenceContainers();")
            ->write("\$efBlocks = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfBlocks();")
            ->write("echo '<pre>'; var_dump(\$efBlocks); var_dump(\$referenceContainers);");
    }
}