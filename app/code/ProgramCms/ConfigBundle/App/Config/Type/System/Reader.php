<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App\Config\Type\System;

use ProgramCms\CoreBundle\App\Config\ConfigSourceInterface;
use ProgramCms\WebsiteBundle\Model\Config\Processor\Fallback;

/**
 * Class Reader
 * @package ProgramCms\ConfigBundle\App\Config\Type\System
 */
class Reader
{
    /**
     * @var ConfigSourceInterface
     */
    private ConfigSourceInterface $source;

    /**
     * @var Fallback
     */
    private Fallback $fallback;

    /**
     * Reader constructor.
     * @param ConfigSourceInterface $source
     * @param Fallback $fallback
     */
    public function __construct(
        ConfigSourceInterface $source,
        Fallback $fallback
    )
    {
        $this->source = $source;
        $this->fallback = $fallback;
    }

    /**
     * Retrieve and process system configuration data
     * Processing includes configuration fallback between scopes (default, website, website_view)
     *
     * @return array
     */
    public function read(): array
    {
        return $this->fallback->process(
            $this->source->get()
        );
    }
}