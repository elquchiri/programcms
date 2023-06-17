<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class EFMoveNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFMoveNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($elementName, $destinationName, $before, $after, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['elementName' => $elementName, 'destinationName' => $destinationName, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $elementName = $this->getAttribute('elementName');
        $destinationName = $this->getAttribute('destinationName');
        $before = $this->getAttribute('before');
        $after = $this->getAttribute('after');

        $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension')->moveElement('$elementName', '$destinationName', '$before', '$after');");

        $compiler->subcompile($this->getNode('body'));
    }
}