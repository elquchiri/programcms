<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Model\Provider\Button\Url;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class Save
 * @package ProgramCms\UserBundle\Model\Provider\Button\Group
 */
class Save implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'url_rewrite_form',
            'label' => 'Save URL'
        ];
    }
}