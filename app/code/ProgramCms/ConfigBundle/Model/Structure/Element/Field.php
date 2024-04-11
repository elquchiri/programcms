<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

use ProgramCms\ConfigBundle\Model\Structure\AbstractElement;

/**
 * Class Field
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
class Field extends AbstractElement
{
    /**
     * @return mixed|string
     */
    public function getSourceModel()
    {
        return $this->_data['sourceModel'] ?? '';
    }

    /**
     * @return array|mixed
     */
    public function getScopes()
    {
        return $this->_data['scope'] ?? [];
    }

    /**
     * @return bool
     */
    public function showInDefault(): bool
    {
        return in_array('default', $this->getScopes());
    }

    /**
     * @return bool
     */
    public function showInWebsite(): bool
    {
        return in_array('website', $this->getScopes());
    }

    /**
     * @return bool
     */
    public function showInWebsiteView(): bool
    {
        return in_array('website_view', $this->getScopes());
    }

    /**
     * @return bool
     */
    public function canRestore(): bool
    {
        return in_array('can_restore', $this->getScopes());
    }
}