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

        $blocks = [];
        // Loop over all the tokens until we reach the end of the reference block
//        while (!$stream->test(Token::BLOCK_END_TYPE)) {
//            // Check if the current token is a "EFBlock" tag
//            if ($stream->test(Token::NAME_TYPE, 'EFBlock')) {
//                // Get the name of the block
//                $stream->next();
//                $name = $this->parser->getExpressionParser()->parseExpression()->getAttribute('name');
//                $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
//
//                // Parse the contents of the block
//                $body = $this->parser->subparse([$this, 'parseBlock']);
//
//                // Add the block to the array
//                $blocks[$name] = $body;
//            } else {
//                // If it's not a "myBlock" tag, just skip over the token
//                $this->parser->getStream()->next();
//            }
//        }

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