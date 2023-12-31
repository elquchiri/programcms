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
 * Class JsTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class JsTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    /**
     * @param Token $token
     * @return \ProgramCms\ThemeBundle\Node\JsNode
     * @throws \Twig\Error\SyntaxError
     */
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $jsFiles = [];

        // parse the array of css files
        if ($stream->test(Token::PUNCTUATION_TYPE, '[')) {
            $jsFiles = $this->parseJsFiles();
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\JsNode($jsFiles, $lineno, $this->getTag());
    }

    /**
     * @return array
     * @throws \Twig\Error\SyntaxError
     */
    protected function parseJsFiles()
    {
        $stream = $this->parser->getStream();
        $cssFiles = [];

        // skip over the opening bracket
        $stream->next();

        // parse the array of css files
        while (!$stream->test(Token::PUNCTUATION_TYPE, ']')) {
            $cssFiles[] = $stream->expect(Token::STRING_TYPE)->getValue();

            // skip over the comma or closing bracket
            if ($stream->nextIf(Token::PUNCTUATION_TYPE, ',') === false) {
                break;
            }
        }

        // skip over the closing bracket
        $stream->expect(Token::PUNCTUATION_TYPE, ']');

        return $cssFiles;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'js';
    }
}