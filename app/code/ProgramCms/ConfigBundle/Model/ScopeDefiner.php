<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use ProgramCms\ConfigBundle\App\ScopeConfigInterface;

/**
 * Class ScopeDefiner
 * @package ProgramCms\ConfigBundle\Model
 */
class ScopeDefiner
{
    /**
     * @var Request
     */
    protected Request $_request;

    /**
     * ScopeDefiner constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->_request->getParam(
            'website_view'
        ) ? ScopeInterface::SCOPE_WEBSITE_VIEW : ($this->_request->getParam(
            'website'
        ) ? ScopeInterface::SCOPE_WEBSITE : ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }
}