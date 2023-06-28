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
 * Class TitleTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class TitleTokenParser extends \Twig\TokenParser\AbstractTokenParser
{

    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideTitleEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\TitleNode($body, $lineno, $this->getTag());
    }

    public function decideTitleEnd(\Twig\Token $token)
    {
        return $token->test('endTitle');
    }

    public function getTag()
    {
        return 'title';
    }
}