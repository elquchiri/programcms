<?php


namespace ElectroForums\ThemeBundle\Node;



class EFLayoutNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        foreach($this->getNode('body') as $node) {
            switch ($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                    $containerName = $node->getAttribute('containerName');
                    $compiler
                        ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->addEfRootContainer('$containerName');");
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFReferenceContainerNode):
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}