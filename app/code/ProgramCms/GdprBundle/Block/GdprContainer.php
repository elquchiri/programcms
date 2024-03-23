<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\GdprBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\GdprBundle\Helper\Config;

/**
 * Class GdprContainer
 * @package ProgramCms\GdprBundle\Block
 */
class GdprContainer extends Template
{
    /**
     * @var Config
     */
    protected Config $configHelper;

    /**
     * GdprContainer constructor.
     * @param Template\Context $context
     * @param Config $configHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Config $configHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configHelper = $configHelper;
    }

    /**
     * Get GDPR Text
     * @return string
     */
    public function getGdprContent(): string
    {
        return $this->trans(
            sprintf(
                $this->trans("We use cookies to make our site work and for analytics and content optimization purposes. By using it you agree to the use of cookies for these purposes. See our %s for details."),
                "<a href=\"\">{$this->trans('privacy and cookie policy')}</a>"
            )
        );
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->configHelper->isActive();
    }
}