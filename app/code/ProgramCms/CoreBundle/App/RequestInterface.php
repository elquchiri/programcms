<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Interface RequestInterface
 * @package ProgramCms\CoreBundle\App
 */
interface RequestInterface
{
    /**
     * @param $param
     * @param string $defaultValue
     * @return mixed
     */
    public function getParam($param, string $defaultValue = ''): mixed;

    /**
     * @param $param
     * @param $value
     * @return $this
     */
    public function setParam($param, $value): static;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @return string
     */
    public function getPathInfo(): string;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getEnv(string $key, mixed $default = null): mixed;
}