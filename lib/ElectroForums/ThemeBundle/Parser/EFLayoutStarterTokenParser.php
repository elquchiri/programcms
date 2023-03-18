<?php


namespace ElectroForums\ThemeBundle\Parser;


class EFLayoutStarterTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideBlockEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Parser\EFLayoutStarterNode($body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig\Token $token)
    {
        return $token->test('endEFLayoutStarter');
    }

    public function getTag()
    {
        return 'EFLayoutStarter';
    }
}