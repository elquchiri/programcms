<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Attribute\Frontend;

use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Image
 * @package ProgramCms\ConfigBundle\Model\Attribute\Frontend
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
     * @param $field
     * @param $value
     * @return string
     */
    public function getValue($field, $value): string
    {
        return $this->url->getBaseUrl() . '/media/core_config/' . $value;
    }
}