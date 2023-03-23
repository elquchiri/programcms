<?php


namespace ElectroForums\CoreBundle\Model\Utils;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Url
{

    protected UrlGeneratorInterface $urlGenerator;

    public function __construct(
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getBaseUrl(): string
    {
        return $this->urlGenerator->generate('', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}