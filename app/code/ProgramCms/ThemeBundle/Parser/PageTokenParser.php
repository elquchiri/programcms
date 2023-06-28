<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class PageTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class PageTokenParser extends \Twig\TokenParser\AbstractTokenParser
{

    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        try {
            $stream->expect(Token::NAME_TYPE, 'layout');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $pageLayoutName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $pageLayoutName = "";
        }
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decidePageEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\PageNode($pageLayoutName, $body, $lineno, $this->getTag());
    }

    public function decidePageEnd(\Twig\Token $token)
    {
        return $token->test('endPage');
    }

    public function getTag()
    {
        return 'page';
    }
}