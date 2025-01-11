<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle\Service;

/**
 * Interface UrlInterface
 * @package ProgramCms\RouterBundle\Service
 */
interface UrlInterface
{
    public function getBaseUrl(): string;

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function getUrlByRouteName($routeName, array $params = []): string;

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function getUrlByFullRouteName($routeName, array $params = []): string;

    /**
     * @return string
     */
    public function getRouteName(): string;

    /**
     * @return string
     */
    public function getCurrentUrl(): string;

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public function getUrl(string $routeName, array $params = []): string;
}