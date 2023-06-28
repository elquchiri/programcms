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
 * Class CssTokenParser
 * @package ProgramCms\ThemeBundle\Parser
 */
class CssTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $cssFiles = [];

        // parse the array of css files
        if ($stream->test(Token::PUNCTUATION_TYPE, '[')) {
            $cssFiles = $this->parseCssFiles();
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ProgramCms\ThemeBundle\Node\CssNode($cssFiles, $lineno, $this->getTag());
    }

    protected function parseCssFiles()
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

    public function getTag()
    {
        return 'css';
    }
}