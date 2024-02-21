<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Parser;

use ProgramCms\UiBundle\Twig\Node\FieldNode;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class FieldTokenParser
 * @package ProgramCms\UiBundle\Twig\Parser
 */
class FieldTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return FieldNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        try {
            $stream->expect(Token::NAME_TYPE, 'name');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $name = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $name = null;
        }

        try {
            $stream->expect(Token::NAME_TYPE, 'type');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $type = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $type = null;
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new FieldNode('', ['name' => $name, 'type' => $type], $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'field';
    }
}