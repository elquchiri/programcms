<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Parser;

use ProgramCms\UiBundle\Twig\Node\FormNode;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class FormTokenParser
 * @package ProgramCms\UiBundle\Twig\Parser
 */
class FormTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return FormNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideFormEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new FormNode($body, [], $lineno, $this->getTag());
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideFormEnd(\Twig\Token $token)
    {
        return $token->test('endForm');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'form';
    }
}