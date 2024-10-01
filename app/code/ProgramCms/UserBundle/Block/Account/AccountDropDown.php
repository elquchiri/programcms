<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account;

use ProgramCms\CoreBundle\View\Element\Template;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class AccountDropDown
 * @package ProgramCms\UserBundle\Block\Account
 */
class AccountDropDown extends Template
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * AccountDropDown constructor.
     * @param Template\Context $context
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->security = $security;
    }

    /**
     * @return string
     */
    public function getUserUrl(): string {
        return $this->getUrl('user_profile_view', ['id' => $this->security->getUser()->getEntityId()]);
    }
}