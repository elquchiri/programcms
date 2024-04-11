<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Adminhtml;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\DateTime\TransformerInterface;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\View\Element\Context;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Exception;
use ProgramCms\UserBundle\Repository\UserLogRepository;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;

/**
 * Class AccountView
 * @package ProgramCms\UserBundle\Block\Adminhtml
 */
class AccountView extends AbstractComponent
{
    const NAME = 'account_view';

    const EMAIL_CONFIRMATION_CONFIG = 'user_configuration/account_create/email_confirmation';

    /**
     * @var UserEntity
     */
    protected UserEntity $user;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var UserLogRepository
     */
    protected UserLogRepository $userLogRepository;

    /**
     * AccountView constructor.
     * @param Context $context
     * @param UserEntityRepository $userEntityRepository
     * @param TransformerInterface $transformer
     * @param Config $config
     * @param UserLogRepository $userLogRepository
     * @param array $data
     * @throws Exception
     */
    public function __construct(
        Context $context,
        UserEntityRepository $userEntityRepository,
        TransformerInterface $transformer,
        Config $config,
        UserLogRepository $userLogRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->userEntityRepository = $userEntityRepository;
        $this->user = $this->getUser();
        $this->transformer = $transformer;
        $this->config = $config;
        $this->userLogRepository = $userLogRepository;
    }

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUserBundle/account_view.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return UserEntity
     * @throws Exception
     */
    public function getUser(): UserEntity
    {
        $userId = $this->getRequest()->getParam('id');
        /** @var UserEntity $user */
        $user = $this->userEntityRepository->getById($userId);
        if(!$user) {
            throw new Exception("User not found.");
        }
        return $user;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getLockLabel(): string
    {
        return $this->user->isLocked() ? $this->trans("Locked") : $this->trans('Unlocked');
    }

    /**
     * @return string
     */
    public function getAccountCreationDate(): string
    {
        return $this->trans($this->transformer->transform($this->user->getCreatedAt()));
    }

    /**
     * @return string|null
     */
    public function getAccountWebsiteView(): ?string
    {
        return $this->user->getWebsiteView()->getWebsiteName() . ' &middot; ' . $this->user->getWebsiteView()->getName();
    }

    /**
     * @return string
     */
    public function getEmailConfirmation(): string
    {
        $userWebsiteView = $this->user->getWebsiteView();
        $shouldConfirm = (bool) $this->config->getValue(
            self::EMAIL_CONFIRMATION_CONFIG,
            ScopeInterface::SCOPE_WEBSITE_VIEW,
            $userWebsiteView->getWebsiteViewId()
        );
        if(!$shouldConfirm) {
            return $this->trans('Confirmation Not Required');
        }
        return $this->user->isEmailConfirmed()
            ? $this->trans('Email Confirmed')
            : $this->trans('Email Not Confirmed');
    }

    /**
     * @return string
     */
    public function getLastLog(): string
    {
        $status = $this->trans('(Offline)');
        $lastLog = $this->userLogRepository->getLastLog($this->user);
        if($lastLog) {
            return $this->transformer->transform($lastLog->getUpdatedAt()) . ' ' . $status;
        }
        return $this->trans('Never') . ' ' . $status;
    }
}