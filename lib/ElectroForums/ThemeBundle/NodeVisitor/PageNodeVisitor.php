<?php


namespace ElectroForums\ThemeBundle\NodeVisitor;


use Twig\Environment;
use Twig\Node\Node;

final class PageNodeVisitor implements \Twig\NodeVisitor\NodeVisitorInterface
{
    public function enterNode(Node $node, Environment $env): Node
    {
        return $node;
    }

    public function leaveNode(Node $node, Environment $env): ?Node
    {
        return $node;
    }

    public function getPriority()
    {
        return 0;
    }
}