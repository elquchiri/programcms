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

class EFTitleTokenParser extends \Twig\TokenParser\AbstractTokenParser
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

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideTitleEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Node\EFTitleNode($this->environment, $body, $lineno, $this->getTag());
    }

    public function decideTitleEnd(\Twig\Token $token)
    {
        return $token->test('endEFTitle');
    }

    public function getTag()
    {
        return 'EFTitle';
    }
}