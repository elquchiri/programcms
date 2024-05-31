<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use ProgramCms\CoreBundle\View\Layout\Element;
use ProgramCms\ThemeBundle\Node\ContainerNode;
use Twig\TokenParser\AbstractTokenParser;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class ContainerTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class ContainerTokenParser extends AbstractTokenParser
{
    /**
     * @param Token $token
     * @return ContainerNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $containerName = $stream->expect(Token::STRING_TYPE)->getValue();
        try {
            $stream->expect(Token::NAME_TYPE, Element::CONTAINER_OPT_HTML_TAG);
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $containerHtmlTag = $stream->expect(Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerHtmlTag = '';
        }

        try {
            $stream->expect(Token::NAME_TYPE, Element::CONTAINER_OPT_HTML_CLASS);
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $containerHtmlClass = $stream->expect(Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerHtmlClass = '';
        }

        try {
            $stream->expect(Token::NAME_TYPE, Element::CONTAINER_OPT_HTML_ID);
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $containerIdClass = $stream->expect(Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerIdClass = '';
        }

        try {
            $stream->expect(Token::NAME_TYPE, 'before');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $before = $stream->expect(Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $before = '';
        }

        try {
            $stream->expect(Token::NAME_TYPE, 'after');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $after = $stream->expect(Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $after = '';
        }
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideContainerEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new ContainerNode(
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
     * @param Token $token
     * @return bool
     */
    public function decideContainerEnd(Token $token)
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