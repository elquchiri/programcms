<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\CoreBundle\Helper\State as AppState;

/**
 * Class State
 * @package ProgramCms\CoreBundle\App
 */
class State
{
    const MODE_PRODUCTION = 'prod';

    const MODE_DEVELOPER = 'dev';

    /**
     * @var string|mixed
     */
    protected string $runType;

    /**
     * @var string|mixed
     */
    protected string $runCode;

    /**
     * Area code
     *
     * @var string
     */
    protected string $_areaCode = '';

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * State constructor.
     * @param Request $request
     */
    public function __construct(
        Request $request,
    )
    {
        $this->request = $request;
        $this->runType = $this->request->getEnv(AppState::ENV_RUN_TYPE, AppState::DEFAULT_RUN_TYPE);
        $this->runCode = $this->request->getEnv(AppState::ENV_RUN_CODE, AppState::DEFAULT_RUN_CODE);
    }

    /**
     * Set Area Code
     * @param $areaCode
     * @return $this
     */
    public function setAreaCode($areaCode): static
    {
        $this->_areaCode = $areaCode;
        return $this;
    }

    /**
     * Get Area Code
     * @return string
     */
    public function getAreaCode(): string
    {
        return $this->_areaCode;
    }

    /**
     * @return string
     */
    public function getCurrentRunCode(): string
    {
        return $this->runCode;
    }

    /**
     * @return string
     */
    public function getCurrentRunType(): string
    {
        return $this->runType;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->request->getEnv('APP_ENV');
    }
}