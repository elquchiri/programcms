<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button\Address;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class BackToUserButton
 * @package ProgramCms\UserBundle\Model\Provider\Button\Address
 */
class BackToUserButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * BackToUsersButton constructor.
     * @param Url $url
     * @param Request $request
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Url $url,
        Request $request,
        UserEntityRepository $userRepository
    )
    {
        $this->url = $url;
        $this->request = $request;
        $this->userRepository = $userRepository;
    }
    /**
     * @return string[]
     */
    public function getData(): array
    {
        $userId = $this->request->getParam('user');
        /** @var UserEntity $user */
        $user = $this->userRepository->getById($userId);

        return [
            'buttonType' => 'back',
            'class' => 'back',
            'buttonAction' => $this->url->getUrlByRouteName('user_index_edit', ['id' => $user->getEntityId()]) . '#user_addresses',
            'label' => 'back'
        ];
    }
}