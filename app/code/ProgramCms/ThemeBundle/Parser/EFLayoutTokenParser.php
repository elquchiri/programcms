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
 * Class EFLayoutTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class EFLayoutTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideLayoutEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\EFLayoutNode($body, $lineno, $this->getTag());
    }

    public function decideLayoutEnd(Token $token)
    {
        return $token->test('endEFLayout');
    }

    public function getTag()
    {
        return 'EFLayout';
    }
}