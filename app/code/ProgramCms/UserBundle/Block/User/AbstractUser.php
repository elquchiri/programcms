<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\User;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class AbstractUser
 * @package ProgramCms\UserBundle\Block\User
 */
class AbstractUser extends Template
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * AbstractUser constructor.
     * @param Template\Context $context
     * @param UserEntityRepository $userRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        UserEntityRepository $userRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        $id = $this->getRequest()->getParam('id');
        return $this->userRepository->getById($id);
    }
}