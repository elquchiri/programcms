<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdsenseBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\AdsenseBundle\Helper\Config as AdsenseHelper;

/**
 * Class Adsense
 * @package ProgramCms\AdsenseBundle\Block
 */
class Adsense extends Template
{
    /**
     * @var AdsenseHelper
     */
    protected AdsenseHelper $adsenseHelper;

    /**
     * Adsense constructor.
     * @param Template\Context $context
     * @param AdsenseHelper $adsenseHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        AdsenseHelper $adsenseHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->adsenseHelper = $adsenseHelper;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->adsenseHelper->isGoogleAdsenseEnabled();
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->adsenseHelper->getClientId();
    }
}