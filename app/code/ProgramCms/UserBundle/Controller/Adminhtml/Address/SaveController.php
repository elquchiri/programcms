<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Address;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityRepository;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class SaveController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Address
 */
class SaveController extends AdminController
{
    /**
     * @var UserAddressEntityRepository
     */
    protected UserAddressEntityRepository $addressRepository;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param UserAddressEntityRepository $addressRepository
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        UserAddressEntityRepository $addressRepository,
        UserEntityRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->addressRepository = $addressRepository;
        $this->userRepository = $userRepository;
    }

    public function execute()
    {
        $addressId = $this->getRequest()->getParam('entity_id');
        $city = $this->getRequest()->getParam('city');
        $country = $this->getRequest()->getParam('country_code');
        $firstName = $this->getRequest()->getParam('firstname');
        $lastName = $this->getRequest()->getParam('lastname');
        $street = $this->getRequest()->getParam('street');
        $postCode = $this->getRequest()->getParam('postcode');

        if(!empty($addressId)) {
            /** @var UserAddressEntity $address */
            $address = $this->addressRepository->getById($addressId);
        }else{
            $userId = $this->getRequest()->getParam('user_id');
            /** @var UserEntity $user */
            $user = $this->userRepository->getById($userId);
            $address = new UserAddressEntity();
            $address->setUser($user);
        }

        $address
            ->setIsActive(true)
            ->setCity($city)
            ->setCountryCode($country)
            ->setFirstname($firstName)
            ->setLastname($lastName)
            ->setStreet($street)
            ->setPostcode((int)$postCode)
            ->updateTimestamps();
        $this->addressRepository->save($address);
        $this->addFlash('success', $this->trans('Address successfully saved.'));
        return $this->redirect($this->url->getUrlByRouteName('user_address_edit', [
            'id' => $address->getEntityId(),
            'user' => $address->getUser()->getEntityId()
        ]));
    }
}