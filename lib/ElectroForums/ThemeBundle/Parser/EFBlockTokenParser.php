<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Parser;


use Twig\Error\SyntaxError;

class EFBlockTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig\Token::NAME_TYPE, 'name');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $blockName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        $stream->expect(\Twig\Token::NAME_TYPE, 'class');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $blockClass = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        $stream->expect(\Twig\Token::NAME_TYPE, 'template');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $blockTemplate = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
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

        return new \ElectroForums\ThemeBundle\Node\EFBlockNode($blockName, $blockClass, $blockTemplate, $before, $after, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig\Token $token)
    {
        return $token->test('endEFBlock');
    }

    public function getTag()
    {
        return 'EFBlock';
    }
}