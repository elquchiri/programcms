<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute\Frontend;

use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Image
 * @package ProgramCms\EavBundle\Model\Entity\Attribute\Frontend
 */
class Image extends AbstractFrontend
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Image constructor.
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * @param string $attributeCode
     * @param $value
     * @param object $object
     * @return string
     */
    public function getValue(string $attributeCode, $value, object $object): string
    {
        $tableName = $object->getTableName();
        return $this->url->getBaseUrl() . '/media/' . $tableName . '/' . $attributeCode . '/' . $value;
    }
}