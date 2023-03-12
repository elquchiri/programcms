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
            ->write("\$containers = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfContainers();")
            ->write("\$efBlocks = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\ReferenceBlockExtension')->getEfBlocks();")
            ->write("foreach(\$containers as \$container) {")
                ->write('echo "<$container[htmlTag] class=\'$container[htmlClass]\'>";')
                ->write("foreach(\$container['blocks'] as \$block) {")
                    ->write("echo \$efBlocks[\$block];")
                ->write("}")
                ->write('echo "</$container[htmlTag]>";')
            ->write("}");
    }
}