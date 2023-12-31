<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use Twig\Error\SyntaxError;
use Twig\Token;

/**
 * Class BlockTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class BlockTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $blockName = $stream->expect(Token::STRING_TYPE)->getValue();

        $stream->expect(Token::NAME_TYPE, 'class');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $blockClass = $stream->expect(Token::STRING_TYPE)->getValue();

        try {
            $stream->expect(Token::NAME_TYPE, 'template');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $blockTemplate = $stream->expect(Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $blockTemplate = '';
        }

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

        $body = $this->parser->subparse([$this, 'decideBlockEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\BlockNode($body, ['name' => $blockName, 'blockClass' => $blockClass, 'blockTemplate' => $blockTemplate, 'before' => $before, 'after' => $after], $lineno, $this->getTag());
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideBlockEnd(Token $token)
    {
        return $token->test('endBlock');
    }

    public function getTag()
    {
        return 'block';
    }
}