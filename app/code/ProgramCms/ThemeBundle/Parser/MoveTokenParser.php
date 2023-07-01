<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use Twig\Error\SyntaxError;

/**
 * Class MoveTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class MoveTokenParser extends \Twig\TokenParser\AbstractTokenParser
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

        return new \ProgramCms\ThemeBundle\Node\MoveNode($elementName, $destinationName, $before, $after, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'move';
    }
}