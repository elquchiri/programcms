<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\DateTime;

use DateTime;
use ProgramCms\CoreBundle\App\Config;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * Class Transformer
 * @package ProgramCms\CoreBundle\DateTime
 */
class Transformer implements TransformerInterface
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Transformer constructor.
     * @param Config $config
     */
    public function __construct(
        Config $config
    )
    {
        $this->config = $config;
    }

    /**
     * @param DateTime $dateTime
     * @param string $format
     * @return string
     */
    public function transform(DateTime $dateTime, string $format = self::DEFAULT_FORMAT): string
    {
        $timezone = $this->config->getValue(self::TIMEZONE_CONFIG_PATH, ScopeInterface::SCOPE_WEBSITE_VIEW);
        $dateTimeString = new DateTimeToStringTransformer($timezone, $timezone, $format, null);
        return $dateTimeString->transform($dateTime);
    }
}