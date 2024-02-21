<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Parser;

use ProgramCms\UiBundle\Twig\Node\UiComponentNode;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class UiComponentTokenParser
 * @package ProgramCms\UiBundle\Twig\Parser
 */
class UiComponentTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return UiComponentNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        try {
            $stream->expect(Token::NAME_TYPE, 'name');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $componentFile = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $componentFile = null;
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new UiComponentNode(
            '',
            ['name' => $componentFile],
            $lineno,
            $this->getTag()
        );
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'uiComponent';
    }
}