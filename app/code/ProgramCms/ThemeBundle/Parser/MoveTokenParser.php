<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use ProgramCms\ThemeBundle\Node\MoveNode;
use Twig\Error\SyntaxError;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class MoveTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class MoveTokenParser extends AbstractTokenParser
{
    /**
     * @param Token $token
     * @return MoveNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $elementName = $stream->expect(Token::STRING_TYPE)->getValue();

        $stream->expect(Token::NAME_TYPE, 'destination');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $destinationName = $stream->expect(Token::STRING_TYPE)->getValue();

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

        return new MoveNode($elementName, $destinationName, $before, $after, $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'move';
    }
}