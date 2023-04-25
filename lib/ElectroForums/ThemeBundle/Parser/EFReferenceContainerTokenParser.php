<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Parser;

use Twig\Error\SyntaxError;
use Twig\Token;

class EFReferenceContainerTokenParser extends \Twig\TokenParser\AbstractTokenParser
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
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideBlockEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Node\EFReferenceContainerNode($containerName, $remove, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(Token $token)
    {
        return $token->test('endEFReferenceContainer');
    }

    public function getTag()
    {
        return 'EFReferenceContainer';
    }
}