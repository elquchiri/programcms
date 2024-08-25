<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account\Edit;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Intl\Countries;

/**
 * Class Dashboard
 * @package ProgramCms\UserBundle\Block\Account\Edit
 */
class Dashboard extends Template
{
    protected Security $security;

    /**
     * Dashboard constructor.
     * @param Template\Context $context
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
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        /** @var UserEntity $user */
        $user = $this->security->getUser();
        return $user;
    }

    /**
     * @return UserAddressEntity
     */
    public function getUserDefaultAddress(): UserAddressEntity
    {
        return $this->getUser()->getDefaultAddress();
    }

    /**
     * @return string
     */
    public function getCountryByCode(): string
    {
        return Countries::getName($this->getUserDefaultAddress()->getCountryCode());
    }

    /**
     * @return string
     */
    public function getEditInformationUrl(): string
    {
        return $this->getUrl('user_edit_information');
    }

    /**
     * @return string
     */
    public function getEditPasswordUrl(): string
    {
        return $this->getUrl('user_edit_password');
    }

    /**
     * @return string
     */
    public function getUserAddressesUrl(): string
    {
        return $this->getUrl('user_address_index');
    }

    /**
     * @return string
     */
    public function getUserFavoriteUrl(): string
    {
        return $this->getUrl('favorite_index_index');
    }

    /**
     * @return string
     */
    public function getDefaultAddressEditUrl(): string
    {
        $id = $this->getUserDefaultAddress()->getEntityId();
        return $this->getUrl('user_address_edit', ['id' => $id]);
    }

    /**
     * @return string
     */
    public function getFavoriteMessage(): string
    {
        $favoriteNum = $this->getUser()->getFavorite()->count();
        return sprintf($this->trans('You have %s subjects in your list.'), $favoriteNum);
    }
}