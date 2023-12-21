<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\Button;

/**
 * Class SaveWebsiteViewButton
 * @package ProgramCms\WebsiteBundle\Model\Provider\Button
 */
class SaveWebsiteViewButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'website_view_form',
            'label' => 'Save View'
        ];
    }
}