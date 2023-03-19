<?php


namespace ElectroForums\ThemeBundle\Node;


use Twig\Environment;
use Twig\Source;

class EFUpdateNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    protected Environment $environment;

    public function __construct(Environment $environment, $handle, $lineno, $tag = null)
    {
        parent::__construct([], ['handle' => $handle], $lineno, $tag);
        $this->environment = $environment;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     */
    public function compile(\Twig\Compiler $compiler)
    {
        // TODO: Checks for Authorized EFPage children or throw an Exception if anything else found.
        $handle = 'C:\Users\Mohamed\EF\lib\ElectroForums\ThemeBundle\Resources/page_layout/' . $this->getAttribute('handle');
        $handle = sprintf("%s.layout.twig", $handle);

        $source = new Source(file_get_contents($handle), 'LayoutHandler');
        $nodes = $this->environment->parse($this->environment->tokenize($source));

        $compiler->subcompile($nodes->getNode('body'));
    }
}