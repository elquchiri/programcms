<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Save;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityRepository;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class AddressController
 * @package ProgramCms\UserBundle\Controller\Save
 */
class AddressController extends Controller
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var UserAddressEntityRepository
     */
    protected UserAddressEntityRepository $addressEntityRepository;

    /**
     * AddressController constructor.
     * @param Context $context
     * @param Security $security
     * @param UserEntityRepository $userRepository
     * @param UserAddressEntityRepository $addressEntityRepository
     */
    public function __construct(
        Context $context,
        Security $security,
        UserEntityRepository $userRepository,
        UserAddressEntityRepository $addressEntityRepository
    )
    {
        parent::__construct($context);
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->addressEntityRepository = $addressEntityRepository;
    }


    public function execute()
    {
        $addressId = $this->getRequest()->getParam('id');
        $firstname = $this->getRequest()->getParam('firstname');
        $lastname = $this->getRequest()->getParam('lastname');
        $telephone = $this->getRequest()->getParam('telephone');
        $street = $this->getRequest()->getParam('street');
        $street2 = $this->getRequest()->getParam('street2');
        $city = $this->getRequest()->getParam('city');
        $country = $this->getRequest()->getParam('country');
        $zipcode = $this->getRequest()->getParam('zipcode');
        $region = $this->getRequest()->getParam('region');
        $isDefaultAddress = (bool) $this->getRequest()->getParam('default_address');

        /** @var UserEntity $user */
        $user = $this->security->getUser();
        if (empty($firstname) || empty($lastname) || empty($telephone) || empty($street) || empty($city) || empty($country) || empty($zipcode)) {
            $this->addFlash('danger',
                $this->translator->trans('The provided informations are not valid, please try again.')
            );
            return $this->redirect($this->url->getUrlByRouteName('user_address_new'));
        }

        if($this->getRequest()->hasParam('id')) {
            $address = $this->addressEntityRepository->getById($addressId);
        }else {
            $address = new UserAddressEntity();
            $address->setCreatedAt();
        }

        $address
            ->setIsActive(true)
            ->setUser($user)
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setTelephone($telephone)
            ->setStreet($street . ' ' . $street2)
            ->setCity($city)
            ->setCountryCode($country)
            ->setZipcode($zipcode)
            ->setRegion($region)
            ->setUpdatedAt();
        $this->addressEntityRepository->save($address);

        // Save User's Default Address if checked
        if($isDefaultAddress) {
            $user->setDefaultAddress($address);
            $this->userRepository->save($user);
        }

        $this->addFlash('success',
            $this->translator->trans('Address Successfully Saved.')
        );

        return $this->redirect($this->url->getUrlByRouteName('user_address_index'));
    }
}