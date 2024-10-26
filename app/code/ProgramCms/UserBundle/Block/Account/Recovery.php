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
use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class Recovery
 * @package ProgramCms\UserBundle\Block\Account
 */
class Recovery extends Template
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
    public function getSubmitUrl(): string
    {
        return $this->url->getUrlByRouteName('user_recovery_index');
    }
}