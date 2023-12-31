<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser\Argument;

use ProgramCms\ThemeBundle\Node\Argument\ArgumentsNode;
use Twig\Error\SyntaxError;
use Twig\Token;

/**
 * Class ArgumentsTokenParser
 * @package ProgramCms\ThemeBundle\Parser\Argument
 */
class ArgumentsTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return ArgumentsNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideArgumentsEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new ArgumentsNode($body, [], $lineno, $this->getTag());
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideArgumentsEnd(Token $token)
    {
        return $token->test('endArguments');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'arguments';
    }
}