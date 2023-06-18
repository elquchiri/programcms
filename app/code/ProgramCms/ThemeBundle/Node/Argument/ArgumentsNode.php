<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node\Argument;

/**
 * Class ArgumentsNode
 * @package ProgramCms\ThemeBundle\Node\Argument
 */
class ArgumentsNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('body'));
    }
}