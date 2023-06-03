<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\RouterBundle\Service;

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