<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser\Argument;

use Twig\Error\SyntaxError;

/**
 * Class ArgumentTokenParser
 * @package ProgramCms\ThemeBundle\Parser\Argument
 */
class ArgumentTokenParser extends \Twig\TokenParser\AbstractTokenParser
{

    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(\Twig\Token::NAME_TYPE, 'name');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $argumentName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();

        $stream->expect(\Twig\Token::NAME_TYPE, 'type');
        $stream->expect(\Twig\Token::OPERATOR_TYPE, '=');
        $argumentType = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideArgumentEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\Argument\ArgumentNode($argumentName, $argumentType, $body, $lineno, $this->getTag());
    }

    public function decideArgumentEnd(\Twig\Token $token)
    {
        return $token->test('endArgument');
    }

    public function getTag()
    {
        return 'argument';
    }
}