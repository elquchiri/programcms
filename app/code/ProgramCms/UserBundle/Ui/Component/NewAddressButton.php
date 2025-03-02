<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Ui\Component;

use ProgramCms\UiBundle\Component\Form\Element\Button;
use ProgramCms\UiBundle\View\Element\Context;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class NewAddressButton
 * @package ProgramCms\UserBundle\Ui\Component
 */
class NewAddressButton extends Button
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * NewAddressButton constructor.
     * @param Context $context
     * @param UserEntityRepository $userRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        UserEntityRepository $userRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->userRepository = $userRepository;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        $userId = $this->getRequest()->getParam('id');
        $user = $this->userRepository->getById($userId);
        return $this->getUrl('user_address_new', ['user' => $user->getEntityId()]);
    }
}