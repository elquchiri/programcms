<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

/**
 * Class MoveNode
 * @package ProgramCms\ThemeBundle\Node
 */
class MoveNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($elementName, $destinationName, $before, $after, $lineno, $tag = null)
    {
        parent::__construct([], ['elementName' => $elementName, 'destinationName' => $destinationName, 'before' => $before, 'after' => $after], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $elementName = $this->getAttribute('elementName');
        $destinationName = $this->getAttribute('destinationName');
        $before = $this->getAttribute('before');
        $after = $this->getAttribute('after');

        $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addElementToMove('$elementName', '$destinationName', '$before', '$after');");
    }
}