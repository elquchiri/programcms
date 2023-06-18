<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node\Argument;

/**
 * Class ArgumentNode
 * @package ProgramCms\ThemeBundle\Node\Argument
 */
class ArgumentNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($argumentName, $argumentType, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['argumentName' => $argumentName, 'argumentType' => $argumentType], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {

    }
}