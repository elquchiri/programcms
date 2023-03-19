<?php


namespace ElectroForums\ThemeBundle\Node;


class EFLayoutStarterNode extends \Twig\Node\Node implements \Twig\Node\NodeOutputInterface
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        // We can also use ob_start() and ob_get_clean() with a $compiler->write("\n") to buffer output
        $compiler->subcompile($this->getNode('body'))
            ->write("\$efCss = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->getEfCss();")
            ->write("\$efJs = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->getEfJs();")
            ->write("\$efContainers = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->getEfContainers();")
            ->write("\$efBlocks = \$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->getEfBlocks();")
            ->write("echo '<pre>'; var_dump(\$efContainers);");
            //->write("echo \$this->env->render('@ElectroForumsTheme/base.html.twig', ['efCss' => \$efCss, 'efJs' => \$efJs, 'efContainers' => \$efContainers, 'efBlocks' => \$efBlocks]);");
    }
}