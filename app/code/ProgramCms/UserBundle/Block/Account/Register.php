<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Model\Provider\CountrySelector;

/**
 * Class Register
 * @package ProgramCms\UserBundle\Block\Account
 */
class Register extends Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var CountrySelector
     */
    protected CountrySelector $countrySelector;

    /**
     * Register constructor.
     * @param Context $context
     * @param Url $url
     * @param CountrySelector $countrySelector
     * @param array $data
     */
    public function __construct(
        Context $context,
        Url $url,
        CountrySelector $countrySelector,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
        $this->countrySelector = $countrySelector;
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

    /**
     * @return string
     */
    public function getCountries(): string
    {
        $selectOptionsHtml = "";
        $countries = $this->countrySelector->getOptionsArray();
        foreach($countries as $code => $country) {
            $selectOptionsHtml .= "<option value='{$code}'>{$country}</option>";
        }
        return $selectOptionsHtml;
    }
}