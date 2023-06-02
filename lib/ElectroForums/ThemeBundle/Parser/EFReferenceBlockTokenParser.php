<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Parser;


use Twig\Error\SyntaxError;

class EFReferenceBlockTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig\Token::NAME_TYPE, 'name');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $blockName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();

        try {
            $stream->expect(\Twig\Token::NAME_TYPE, 'remove');
            $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
            $remove = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $remove = '';
        }

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideReferenceBlockEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Node\EFReferenceBlockNode($blockName, $body, $lineno, $this->getTag());
    }

    public function decideReferenceBlockEnd(\Twig\Token $token)
    {
        return $token->test('endEFReferenceBlock');
    }

    public function getTag()
    {
        return 'EFReferenceBlock';
    }
}