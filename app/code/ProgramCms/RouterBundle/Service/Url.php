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
    /**
     * @var UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;
    /**
     * @var \ProgramCms\CoreBundle\App\AreaList
     */
    protected \ProgramCms\CoreBundle\App\AreaList $areaList;
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * Url constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param \ProgramCms\CoreBundle\App\AreaList $areaList
     * @param Request $request
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        \ProgramCms\CoreBundle\App\AreaList $areaList,
        \ProgramCms\RouterBundle\Service\Request $request
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->areaList = $areaList;
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->urlGenerator->generate('', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * Generate Url Path by Name
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function getUrlByRouteName($routeName, array $params = []): string
    {
        $routeName = $this->areaList->getCodeByFrontName($this->request->getFrontName()) . '_' . $routeName;
        $urlParams = "";
        foreach($params as $key => $value) {
            $urlParams .= "/" . $key . "/" . $value;
        }
        return $this->urlGenerator->generate($routeName, [], UrlGeneratorInterface::ABSOLUTE_URL) . $urlParams;
    }
}