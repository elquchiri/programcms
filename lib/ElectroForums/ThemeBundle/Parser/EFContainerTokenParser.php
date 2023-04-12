<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Parser;

use Twig\Error\SyntaxError;

class EFContainerTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig\Token::NAME_TYPE, 'name');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $containerName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        try {
            $stream->expect(\Twig\Token::NAME_TYPE, 'htmlTag');
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $containerHtmlTag = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerHtmlTag = '';
        }

        try {
            $stream->expect(\Twig\Token::NAME_TYPE, 'htmlClass');
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $containerHtmlClass = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $containerHtmlClass = '';
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

        $body = $this->parser->subparse([$this, 'decideBlockEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Node\EFContainerNode($containerName, $containerHtmlTag, $containerHtmlClass, $before, $after, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig\Token $token)
    {
        return $token->test('endEFContainer');
    }

    public function getTag()
    {
        return 'EFContainer';
    }
}