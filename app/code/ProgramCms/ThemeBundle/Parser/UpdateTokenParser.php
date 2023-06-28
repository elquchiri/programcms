<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class UpdateTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class UpdateTokenParser extends \Twig\TokenParser\AbstractTokenParser
{

    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        try {
            $stream->expect(Token::NAME_TYPE, 'handle');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $handle = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $handle = null;
        }
        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\UpdateNode($handle, $lineno, $this->getTag());
    }

    public function decideUpdateEnd(\Twig\Token $token)
    {
        return $token->test('endUpdate');
    }

    public function getTag()
    {
        return 'update';
    }
}