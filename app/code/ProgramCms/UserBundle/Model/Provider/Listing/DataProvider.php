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
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DataProvider
 * @package ProgramCms\UserBundle\Model\Provider\Listing
 */
class DataProvider extends AbstractDataProvider
{
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
     * @param array $filterStrategies
     */
    public function __construct(
        Collection $collection,
        TranslatorInterface $translator,
        Config $config,
        array $filterStrategies = []
    )
    {
        $this->collection = $collection;
        $this->translator = $translator;
        $this->config = $config;
        $this->filterStrategies = $filterStrategies;
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
                    'websiteView',
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
        return $user->isEmailConfirmed()
            ? $this->translator->trans('Email Confirmed')
            : $this->translator->trans('Email Not Confirmed');
    }

    /**
     * @param string $field
     * @param $value
     */
    public function addFilter(string $field, $value)
    {
        if(isset($this->filterStrategies[$field])) {
            $this->filterStrategies[$field]->addFilter($this->getCollection(), $field, $value);
        }else{
            parent::addFilter($field, $value);
        }
    }
}