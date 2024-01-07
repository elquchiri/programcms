<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing\Toolbar;

/**
 * Class MassActions
 * @package ProgramCms\UiBundle\Component\Listing\Toolbar
 */
class MassActions extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'massActions';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/toolbar/mass_actions.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    public function prepareActions()
    {
        $optionsHtml = "";
        $settings = $this->getData('settings');
        foreach($settings as $actionName => $action) {
            $optionsHtml .= sprintf(
                "<option value=\"%s\">%s</option>",
                $action['url'],
                $this->trans($action['label'])
            );
        }
        return $optionsHtml;
    }
}