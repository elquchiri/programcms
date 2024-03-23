<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use ProgramCms\ThemeBundle\Node\RequireNode;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class RequireTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class RequireTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return RequireNode
     * @throws SyntaxError
     */
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

        return new RequireNode('', ['handle' => $handle], $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'require';
    }
}