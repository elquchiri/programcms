<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class Community
 * @package ProgramCms\UserBundle\Block
 */
class Community extends Template
{
    protected UserEntityRepository $userRepository;

    /**
     * Community constructor.
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
     * @return array
     */
    public function getUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param UserEntity $user
     * @return string
     */
    public function getUserUrl(UserEntity $user): string
    {
        return $this->getUrl('user_profile_view', ['id' => $user->getEntityId()]);
    }
}