<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Model\Provider\Button;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class NewFileButton
 * @package ProgramCms\DriveBundle\Model\Provider\Button
 */
class NewFileButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * NewFolderButton constructor.
     * @param Url $url
     */
    public function __construct(
        Url $url
    )
    {
        $this->url = $url;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => 'user_form',
            'label' => 'New File'
        ];
    }
}