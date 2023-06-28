<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use Twig\Token;

/**
 * Class LayoutTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class LayoutTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideLayoutEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\LayoutNode($body, $lineno, $this->getTag());
    }

    public function decideLayoutEnd(Token $token)
    {
        return $token->test('endLayout');
    }

    public function getTag()
    {
        return 'layout';
    }
}