<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Listing;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Model\ResourceModel\User\Collection;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DataProvider
 * @package ProgramCms\UserBundle\Model\Provider\Listing
 */
class DataProvider extends AbstractDataProvider
{
    const EMAIL_CONFIRMATION_CONFIG = 'user_configuration/account_create/email_confirmation';

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param TranslatorInterface $translator
     * @param Config $config
     */
    public function __construct(
        Collection $collection,
        TranslatorInterface $translator,
        Config $config
    )
    {
        $this->collection = $collection;
        $this->translator = $translator;
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        $data = parent::getData();
        /** @var UserEntity $item */
        foreach($data as $item) {
            $item
                ->setData(
                    'website_view',
                    $item->getWebsiteView()->getWebsiteName() . ' &middot; ' . $item->getWebsiteView()->getName()
                )
                ->setData('confirmed_email', $this->getEmailConfirmation($item));
        }
        return $data;
    }

    /**
     * @param UserEntity $user
     * @return string
     */
    private function getEmailConfirmation(UserEntity $user): string
    {
        $userWebsiteView = $user->getWebsiteView();
        $shouldConfirm = (bool) $this->config->getValue(
            self::EMAIL_CONFIRMATION_CONFIG,
            ScopeInterface::SCOPE_WEBSITE_VIEW,
            $userWebsiteView->getWebsiteViewId()
        );
        if(!$shouldConfirm) {
            return $this->translator->trans('Confirmation Not Required');
        }
        return $user->isEmailConfirmed()
            ? $this->translator->trans('Email Confirmed')
            : $this->translator->trans('Email Not Confirmed');
    }
}