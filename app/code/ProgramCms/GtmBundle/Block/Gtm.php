<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\GtmBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\GtmBundle\Helper\Config as GtmHelper;

/**
 * Class Gtm
 * @package ProgramCms\GtmBundle\Block
 */
class Gtm extends Template
{
    /**
     * @var GtmHelper
     */
    protected GtmHelper $gtmHelper;

    /**
     * Gtm constructor.
     * @param Template\Context $context
     * @param GtmHelper $gtmHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        GtmHelper $gtmHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->gtmHelper = $gtmHelper;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->gtmHelper->isGtmEnabled();
    }

    /**
     * @return string|null
     */
    public function getContainerId(): ?string
    {
        return $this->gtmHelper->getContainerId();
    }
}