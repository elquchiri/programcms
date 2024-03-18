<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\GdprBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class GdprContainer
 * @package ProgramCms\GdprBundle\Block
 */
class GdprContainer extends Template
{
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
}