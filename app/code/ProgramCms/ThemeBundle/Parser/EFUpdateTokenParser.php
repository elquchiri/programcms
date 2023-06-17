<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Parser;

use Twig\Environment;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class EFUpdateTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class EFUpdateTokenParser extends \Twig\TokenParser\AbstractTokenParser
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
            $stream->expect(Token::NAME_TYPE, 'handle');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $handle = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $handle = null;
        }
        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\EFUpdateNode($this->environment, $handle, $lineno, $this->getTag());
    }

    public function decideUpdateEnd(\Twig\Token $token)
    {
        return $token->test('endEFUpdate');
    }

    public function getTag()
    {
        return 'EFUpdate';
    }
}