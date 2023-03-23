<?php


namespace ElectroForums\ThemeBundle\Node;


class EFContainerNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($containerName, $containerHtmlTag, $containerHtmlClass, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['containerName' => $containerName, 'containerHtmlTag' => $containerHtmlTag, 'containerHtmlClass' => $containerHtmlClass], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $containerName = $this->getAttribute('containerName');

        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFBlockNode):
                    $blockName = $node->getAttribute('blockName');
                    //$compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->addReferenceContainer('$containerName', '$blockName');");
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                    $subContainerName = $node->getAttribute('containerName');
                    $subContainerHtmlTag = $node->getAttribute('containerHtmlTag');
                    $subContainerHtmlClass = $node->getAttribute('containerHtmlClass');
                    $compiler->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Twig\EFThemeExtension')->addEfContainer('$subContainerName', '$containerName', '$subContainerHtmlTag', '$subContainerHtmlClass');");
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}