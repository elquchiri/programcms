<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser\Argument;

/**
 * Class ArgumentsTokenParser
 * @package ProgramCms\ThemeBundle\Parser\Argument
 */
class ArgumentsTokenParser extends \Twig\TokenParser\AbstractTokenParser
{

    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideArgumentsEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\Argument\ArgumentsNode($body, $lineno, $this->getTag());
    }

    public function decideArgumentsEnd(\Twig\Token $token)
    {
        return $token->test('endArguments');
    }

    public function getTag()
    {
        return 'arguments';
    }
}