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
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityRepository;
use ProgramCms\WebsiteBundle\Model\Provider\CountrySelector;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Address
 * @package ProgramCms\UserBundle\Block\Account\Edit
 */
class Address extends Template
{
    /**
     * @var CountrySelector
     */
    protected CountrySelector $countrySelector;

    /**
     * @var UserAddressEntityRepository
     */
    protected UserAddressEntityRepository $addressEntityRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * Address constructor.
     * @param Template\Context $context
     * @param CountrySelector $countrySelector
     * @param UserAddressEntityRepository $addressEntityRepository
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CountrySelector $countrySelector,
        UserAddressEntityRepository $addressEntityRepository,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->countrySelector = $countrySelector;
        $this->addressEntityRepository = $addressEntityRepository;
        $this->security = $security;
    }

    /**
     * @return string
     */
    public function getNewAddressUrl(): string
    {
        return $this->getUrl('user_address_new');
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

    /**
     * @return string
     */
    public function getSaveAddressUrl(): string
    {
        return $this->getUrl('user_save_address');
    }

    /**
     * @return array
     */
    public function getAddresses(): array
    {
        $user = $this->security->getUser();
        return $this->addressEntityRepository->findBy([
            'user' => $user
        ]);
    }

    /**
     * @param UserAddressEntity $address
     * @return string
     */
    public function getEditAddressUrl(UserAddressEntity $address): string
    {
        return $this->getUrl('user_address_edit', ['id' => $address->getEntityId()]);
    }

    /**
     * @return UserAddressEntity|bool
     */
    public function getAddress(): UserAddressEntity|bool
    {
        if(!$this->getRequest()->hasParam('id')) {
            return false;
        }

        $id = $this->getRequest()->getParam('id');
        return $this->addressEntityRepository->getById($id);
    }

    /**
     * @return string
     */
    public function getAddressId(): string
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * @return bool
     */
    public function isDefaultAddressChecked(): bool
    {
        if($this->getAddress()) {
            $addressId = $this->getRequest()->getParam('id');
            /** @var UserEntity $user */
            $user = $this->security->getUser();
            return $addressId == $user->getDefaultAddress()->getEntityId();
        }
        return false;
    }

    /**
     * @param UserAddressEntity $address
     * @return string
     */
    public function getRemoveAddressUrl(UserAddressEntity $address): string
    {
        return $this->getUrl('user_address_delete', ['id' => $address->getEntityId()]);
    }
}