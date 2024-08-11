<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Address;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityRepository;
use ReflectionException;

/**
 * Class DeleteController
 * @package ProgramCms\UserBundle\Controller\Address
 */
class DeleteController extends Controller
{
    /**
     * @var UserAddressEntityRepository
     */
    protected UserAddressEntityRepository $userAddressRepository;

    /**
     * DeleteController constructor.
     * @param Context $context
     * @param UserAddressEntityRepository $userAddressRepository
     */
    public function __construct(
        Context $context,
        UserAddressEntityRepository $userAddressRepository
    )
    {
        parent::__construct($context);
        $this->userAddressRepository = $userAddressRepository;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        if($this->getRequest()->hasParam('id')) {
            $addressId = $this->getRequest()->getParam('id');
            $address = $this->userAddressRepository->getById($addressId);
            if($address) {
                $this->userAddressRepository->remove($address, true);
                $this->addFlash('success',
                    $this->translator->trans('Address Successfully Removed.')
                );
            }
        }
        return $this->redirect($this->url->getUrlByRouteName('user_address_index'));
    }
}