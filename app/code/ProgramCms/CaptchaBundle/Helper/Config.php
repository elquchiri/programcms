<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CaptchaBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Config
 * @package ProgramCms\CaptchaBundle\Helper
 */
class Config extends AbstractHelper
{
    const REGISTER_ENABLED_CAPTCHA = 'captcha/pages/register';

    /**
     * @return bool
     */
    public function isCaptchaEnabledInRegister(): bool
    {
        return $this->getConfig(self::REGISTER_ENABLED_CAPTCHA);
    }
}