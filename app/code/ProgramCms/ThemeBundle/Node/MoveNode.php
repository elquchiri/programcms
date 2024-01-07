<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Compiler;

/**
 * Class MoveNode
 * @package ProgramCms\ThemeBundle\Node
 */
class MoveNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    /**
     * MoveNode constructor.
     * @param $elementName
     * @param $destinationName
     * @param $before
     * @param $after
     * @param $lineno
     * @param null $tag
     */
    public function __construct($elementName, $destinationName, $before, $after, $lineno, $tag = null)
    {
        parent::__construct([], ['elementName' => $elementName, 'destinationName' => $destinationName, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $elementName = $this->getAttribute('elementName');
        $destinationName = $this->getAttribute('destinationName');
        $before = $this->getAttribute('before');
        $after = $this->getAttribute('after');

        $compiler
            ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addElementToMove('$elementName', '$destinationName', '$before', '$after')")
            ->raw(";\n");
    }
}