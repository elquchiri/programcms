<?php


namespace ElectroForums\ThemeBundle\Node;


class EFReferenceContainerNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($containerName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');
        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFBlockNode):
                    $blockName = $node->getAttribute('blockName');
                    $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->addReferenceContainer('$containerName', '$blockName');");
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):

                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}