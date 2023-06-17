<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class Url
 * @package ProgramCms\RouterBundle\Service
 */
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

    public function getUrlByRouteName($routeName, $params = [])
    {
        $urlParams = "";
        foreach($params as $key => $value) {
            $urlParams .= "/" . $key . "/" . $value;
        }
        return $this->urlGenerator->generate($routeName, [], UrlGeneratorInterface::ABSOLUTE_URL) . $urlParams;
    }
}