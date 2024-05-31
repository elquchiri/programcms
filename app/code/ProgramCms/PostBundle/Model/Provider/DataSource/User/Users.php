<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Provider\DataSource\User;

use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class Users
 * @package ProgramCms\PostBundle\Model\Provider\DataSource\User
 */
class Users extends Options
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * Users constructor.
     * @param UserEntityRepository $userEntityRepository
     */
    public function __construct(
        UserEntityRepository $userEntityRepository
    )
    {
        $this->userEntityRepository = $userEntityRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $usersData = [];
        $users = $this->userEntityRepository->findAll();
        /** @var UserEntity $user */
        foreach($users as $user) {
            $usersData[$user->getEntityId()] = $user->getFullName();
        }
        return $usersData;
    }
}