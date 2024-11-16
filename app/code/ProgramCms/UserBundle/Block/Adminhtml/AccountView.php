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
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ProgramCms\UserBundle\Repository\UserLogRepository;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use Exception;

/**
 * Class AccountView
 * @package ProgramCms\UserBundle\Block\Adminhtml
 */
class AccountView extends AbstractComponent
{
    const NAME = 'account_view';

    const EMAIL_CONFIRMATION_CONFIG = 'user_configuration/account_create/email_confirmation';

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
        $this->userEntityRepository = $userEntityRepository;
        $this->transformer = $transformer;
        $this->config = $config;
        $this->userLogRepository = $userLogRepository;
        parent::__construct($context, $data);
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
        $user = $this->getUser();
        return $user->isLocked() ? $this->trans("Locked") : $this->trans('Unlocked');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getAccountCreationDate(): string
    {
        $user = $this->getUser();
        if($user) {
            return $this->trans($this->transformer->transform($user->getCreatedAt()));
        }
        return '';
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getAccountWebsiteView(): ?string
    {
        $user = $this->getUser();
        return $user->getWebsiteView()->getWebsiteName() . ' &middot; ' . $user->getWebsiteView()->getName();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getEmailConfirmation(): string
    {
        $user = $this->getUser();
        $userWebsiteView = $user->getWebsiteView();
        $shouldConfirm = (bool) $this->config->getValue(
            self::EMAIL_CONFIRMATION_CONFIG,
            ScopeInterface::SCOPE_WEBSITE_VIEW,
            $userWebsiteView->getWebsiteViewId()
        );
        if(!$shouldConfirm) {
            return $this->trans('Confirmation Not Required');
        }
        return $user->isEmailConfirmed()
            ? $this->trans('Email Confirmed')
            : $this->trans('Email Not Confirmed');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getLastLog(): string
    {
        $user = $this->getUser();
        $status = $this->trans('(Offline)');
        $lastLog = $this->userLogRepository->getLastLog($user);
        if($lastLog) {
            return $this->transformer->transform($lastLog->getCreatedAt()) . ' ' . $status;
        }
        return $this->trans('Never') . ' ' . $status;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDefaultAddress(): string
    {
        $address = $this->getUser()->getDefaultAddress();
        $text = "<p class='mb-2'>";
        if(!empty($firstname = $address->getFirstname())) {
            $text .= $firstname . " ";
        }
        if(!empty($lastname = $address->getLastname())) {
            $text .= $lastname;
        }
        $text .= "</p>";
        if(!empty($street = $address->getStreet())) {
            $text .= $street . "<br/>";
        }
        if(!empty($city = $address->getCity())) {
            $text .= $city  . ", ";
        }
        if(!empty($country = $address->getCountry())) {
            $text .= $country  . "<br/>";
        }
        if(!empty($telephone = $address->getTelephone())) {
            $text .= 'T: ' . $telephone;
        }
        return $text;
    }
}