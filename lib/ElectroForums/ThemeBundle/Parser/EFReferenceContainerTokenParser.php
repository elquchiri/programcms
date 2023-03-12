<?php


namespace ElectroForums\ThemeBundle\Parser;

use Twig\Token;

class EFReferenceContainerTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $containerName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideBlockEnd'], true);

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Parser\EFReferenceContainerNode($containerName, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig\Token $token)
    {
        return $token->test('endEFReferenceContainer');
    }

    public function getTag()
    {
        return 'EFReferenceContainer';
    }
}