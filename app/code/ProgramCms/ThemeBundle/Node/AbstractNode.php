<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Class AbstractNode
 * @package ProgramCms\ThemeBundle\Node
 */
abstract class AbstractNode extends Node
{
    /**
     * AbstractNode constructor.
     * @param string $body
     * @param array $attributes
     * @param int $lineno
     * @param string|null $tag
     */
    public function __construct(
        $body = '',
        array $attributes = [],
        int $lineno = 0,
        string $tag = null
    )
    {
        parent::__construct(
            !empty($body) ? ['body' => $body] : [],
            $attributes,
            $lineno,
            $tag
        );
    }

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $this->_compile($compiler);

        if($this->hasNode('body')) {
            $childNodes = $this->getNode('body');

            /** @var Node $childNode */
            foreach ($childNodes as &$childNode) {
                if($childNode instanceof self) {
                    $childNode->setAttribute('parent', $this);
                }
            }

            $compiler->subcompile($childNodes);
        }
    }

    /**
     * Override this method to compile node
     * @param Compiler $compiler
     * @return mixed
     */
    protected function _compile(Compiler &$compiler) {
        return $compiler;
    }
}