<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Parser;

use ProgramCms\UiBundle\Twig\Node\FieldsetNode;
use Twig\Token;
use Twig\Error\SyntaxError;

/**
 * Class FieldsetTokenParser
 * @package ProgramCms\UiBundle\Twig\Parser
 */
class FieldsetTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return FieldsetNode
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        try {
            $stream->expect(Token::NAME_TYPE, 'label');
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $label = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        }catch(SyntaxError $e) {
            $label = null;
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideFieldsetEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new FieldsetNode($body, ['label' => $label], $lineno, $this->getTag());
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideFieldsetEnd(\Twig\Token $token)
    {
        return $token->test('endFieldset');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'fieldset';
    }
}