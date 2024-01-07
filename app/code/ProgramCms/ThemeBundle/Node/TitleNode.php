<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Exception;

/**
 * Class TitleNode
 * @package ProgramCms\ThemeBundle\Node
 */
class TitleNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    /**
     * TitleNode constructor.
     * @param $body
     * @param $lineno
     * @param null $tag
     */
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    /**
     * @throws Exception
     */
    public function compile(\Twig\Compiler $compiler): void
    {
        $title = $this->getNode('body')->getAttribute('data');
        $compiler
            ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->setTitle('$title')")
            ->raw(";\n");
    }
}