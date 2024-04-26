<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Listing\Groups;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\UserBundle\Model\ResourceModel\Group\Collection;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DataProvider
 * @package ProgramCms\UserBundle\Model\Provider\Listing\Groups
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Collection $collection,
        TranslatorInterface $translator,
    )
    {
        $this->collection = $collection;
        $this->translator = $translator;
    }

    public function getData(): mixed
    {
        $data = parent::getData();
//        /** @var UserEntity $item */
//        foreach($data as $item) {
//
//        }
        return $data;
    }
}