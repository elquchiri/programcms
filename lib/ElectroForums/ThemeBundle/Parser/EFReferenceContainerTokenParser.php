<?php


namespace ElectroForums\ThemeBundle\Parser;

use Twig\Token;

class EFReferenceContainerTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::NAME_TYPE, 'name');
        $stream->expect(Token::OPERATOR_TYPE, '=');
        $containerName = $stream->expect(\Twig\Token::STRING_TYPE)->getValue();
        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideBlockEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new \ElectroForums\ThemeBundle\Node\EFReferenceContainerNode($containerName, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(Token $token)
    {
        return $token->test('endEFReferenceContainer');
    }

    public function getTag()
    {
        return 'EFReferenceContainer';
    }
}