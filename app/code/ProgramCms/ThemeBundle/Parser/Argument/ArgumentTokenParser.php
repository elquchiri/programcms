<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser\Argument;

use ProgramCms\ThemeBundle\Node\Argument\ArgumentNode;
use Twig\Error\SyntaxError;
use Twig\Token;

/**
 * Class ArgumentTokenParser
 * @package ProgramCms\ThemeBundle\Parser\Argument
 */
class ArgumentTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return ArgumentNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $argumentName = $stream->expect(Token::STRING_TYPE)->getValue();

        $stream->expect(Token::NAME_TYPE, 'type');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $argumentType = $stream->expect(Token::STRING_TYPE)->getValue();

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideArgumentEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new ArgumentNode(
            $body,
            ['argumentName' => $argumentName, 'argumentType' => $argumentType],
            $lineno,
            $this->getTag()
        );
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideArgumentEnd(Token $token)
    {
        return $token->test('endArgument');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'argument';
    }
}