<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Register
 * @package ProgramCms\UserBundle\Block\Account
 */
class Register extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Register constructor.
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
    public function getRulesAndPolicy(): string
    {
        return sprintf(
            $this->trans('I accept %s and %s'),
            '<a href="#">' . $this->trans('The conditions') . '</a>',
            '<a href="#">' . $this->trans('Confidential policy') . '</a>'
        );
    }

    /**
     * @return string
     */
    public function getSubmitUrl(): string
    {
        return $this->url->getUrlByRouteName('user_account_register');
    }
}