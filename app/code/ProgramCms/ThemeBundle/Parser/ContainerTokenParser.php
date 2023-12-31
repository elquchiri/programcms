<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use ProgramCms\CoreBundle\View\Layout\Element;
use Twig\Error\SyntaxError;

/**
 * Class ContainerTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class ContainerTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param \Twig\Token $token
     * @return \ProgramCms\ThemeBundle\Node\ContainerNode
     * @throws SyntaxError
     */
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig\Token::NAME_TYPE, 'name');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $containerName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        try {
            $stream->expect(\Twig\Token::NAME_TYPE, Element::CONTAINER_OPT_HTML_TAG);
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $containerHtmlTag = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerHtmlTag = '';
        }

        try {
            $stream->expect(\Twig\Token::NAME_TYPE, Element::CONTAINER_OPT_HTML_CLASS);
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $containerHtmlClass = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerHtmlClass = '';
        }

        try {
            $stream->expect(\Twig\Token::NAME_TYPE, Element::CONTAINER_OPT_HTML_ID);
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $containerIdClass = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerIdClass = '';
        }

        try {
            $stream->expect(\Twig\Token::NAME_TYPE, 'before');
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $before = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $before = '';
        }

        try {
            $stream->expect(\Twig\Token::NAME_TYPE, 'after');
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $after = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $after = '';
        }
        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideContainerEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\ContainerNode(
            $body,
            [
                'name' => $containerName,
                'containerHtmlTag' => $containerHtmlTag,
                'containerHtmlClass' => $containerHtmlClass,
                'containerIdClass' => $containerIdClass,
                'before' => $before,
                'after' => $after
            ],
            $lineno,
            $this->getTag()
        );
    }

    /**
     * @param \Twig\Token $token
     * @return bool
     */
    public function decideContainerEnd(\Twig\Token $token)
    {
        return $token->test('endContainer');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'container';
    }
}