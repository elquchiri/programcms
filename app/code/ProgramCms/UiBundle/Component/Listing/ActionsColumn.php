<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

/**
 * Class ActionsColumn
 * @package ProgramCms\UiBundle\Component\Listing
 */
class ActionsColumn extends Column
{
    const NAME = 'actionsColumn';

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $html = "";
        $value = $this->getValue();
        $iterator = 1;
        if(is_array($value)) {
            foreach($value as $action) {
                $html .= sprintf("<a href=\"%s\">%s</a>", $action['url'], $this->trans($action['label']));
                if($iterator < count($value)) {
                    $html .= " &middot; ";
                }
                $iterator++;
            }
        }
        return $html;
    }
}