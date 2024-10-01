<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ForumSuite\ForumBundle\Block\User;

use Doctrine\Common\Collections\Criteria;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class LastUsers
 * @package ProgramCms\ForumBundle\Block\User
 */
class LastUsers extends Template
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * LastUsers constructor.
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
     * @return int|mixed|string
     */
    public function getLastUsers()
    {
        $criteria = Criteria::create()
            ->setMaxResults(3);

        return $this->userRepository->getLastUsers(5);
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