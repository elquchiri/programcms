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
 * Class Login
 * @package ProgramCms\AdminBundle\Block\Account
 */
class Login extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Login constructor.
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
    public function getSubmitUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_index_index');
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->hasData('error') ? $this->getData('error') : '';
    }

    /**
     * @return string
     */
    public function getAdminLoginUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_index_index');
    }

    /**
     * @return string
     */
    public function getLastEmail(): string
    {
        return $this->hasData('lastEmail') ? $this->getData('lastEmail') : '';
    }

    /**
     * @return string
     */
    public function getForgottenPasswordUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_recovery_index');
    }
}