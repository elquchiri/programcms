<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Account;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Navigation
 * @package ProgramCms\AdminBundle\Block\Account
 */
class Navigation extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Navigation constructor.
     * @param Context $context
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Context $context,
        Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getAccountSettingsUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_systemaccount_index');
    }

    /**
     * @return string
     */
    public function getLogoutUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_systemaccount_logout');
    }
}