<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Parser;

use Twig\Error\SyntaxError;

class EFMoveTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig\Token::NAME_TYPE, 'element');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $elementName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();

        $stream->expect(\Twig\Token::NAME_TYPE, 'destination');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $destinationName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();

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

        $body = $this->parser->subparse([$this, 'decideMoveEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Node\EFMoveNode($elementName, $destinationName, $before, $after, $body, $lineno, $this->getTag());
    }

    public function decideMoveEnd(\Twig\Token $token)
    {
        return $token->test('endEFMove');
    }

    public function getTag()
    {
        return 'EFMove';
    }
}