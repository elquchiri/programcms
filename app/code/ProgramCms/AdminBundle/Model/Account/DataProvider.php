<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model\Account;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Model\Collection\Account\Collection;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class DataProvider
 * @package ProgramCms\AdminBundle\Model\Account
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
{
    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * DataProvider constructor.
     * @param AdminUserRepository $adminUserRepository
     * @param Collection $collection
     * @param Security $security
     */
    public function __construct(
        AdminUserRepository $adminUserRepository,
        Collection $collection,
        Security $security
    )
    {
        $this->collection = $collection;
        $this->adminUserRepository = $adminUserRepository;
        $this->security = $security;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $email = $this->security->getUser()->getUserIdentifier();
        return [$this->adminUserRepository->getByEmail($email)];
    }
}