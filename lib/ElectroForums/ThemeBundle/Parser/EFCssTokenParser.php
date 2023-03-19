<?php


namespace ElectroForums\ThemeBundle\Parser;

use Twig\Token;

class EFCssTokenParser extends \Twig\TokenParser\AbstractTokenParser
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

        return new \ElectroForums\ThemeBundle\Node\EFCssNode($cssFiles, $lineno, $this->getTag());
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
        return 'EFCss';
    }
}