<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CoreBundle\View\Element;


abstract class AbstractBlock
{

    public function toHtml()
    {
        return $this->_toHtml();
    }

    /**
     * Used to be Overridden
     * @return string
     */
    protected function _toHtml()
    {
        return '';
    }
}