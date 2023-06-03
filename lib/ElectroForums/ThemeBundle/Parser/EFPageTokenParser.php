<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Parser;

use Twig\Environment;
use Twig\Token;
use Twig\Error\SyntaxError;

class EFPageTokenParser extends \Twig\TokenParser\AbstractTokenParser
{

    protected Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

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

        return new \ElectroForums\ThemeBundle\Node\EFPageNode($this->environment, $pageLayoutName, $body, $lineno, $this->getTag());
    }

    public function decidePageEnd(\Twig\Token $token)
    {
        return $token->test('endEFPage');
    }

    public function getTag()
    {
        return 'EFPage';
    }
}