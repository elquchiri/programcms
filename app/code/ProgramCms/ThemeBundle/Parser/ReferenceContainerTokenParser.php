<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use ProgramCms\CoreBundle\View\Layout\Element;
use ProgramCms\ThemeBundle\Node\ReferenceContainerNode;
use Twig\Error\SyntaxError;
use Twig\Token;

/**
 * Class ReferenceContainerTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class ReferenceContainerTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $containerName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        try {
            $stream->expect(\Twig\Token::NAME_TYPE, 'remove');
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $remove = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $remove = '';
        }

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

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideReferenceContainerEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new ReferenceContainerNode(
            $body,
            [
                'name' => $containerName,
                'remove' => $remove,
                'containerHtmlTag' => $containerHtmlTag,
                'containerHtmlClass' => $containerHtmlClass,
                'containerIdClass' => $containerIdClass
            ],
            $lineno,
            $this->getTag()
        );
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideReferenceContainerEnd(Token $token)
    {
        return $token->test('endReferenceContainer');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'referenceContainer';
    }
}