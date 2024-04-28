<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class NewPostButton
 * @package ProgramCms\PostBundle\Model\Provider\Button
 */
class NewPostButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * NewPostButton constructor.
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'primary',
            'class' => 'btn-primary',
            'buttonAction' => $this->url->getUrlByRouteName('post_index_new'),
            'label' => 'Add New Post'
        ];
    }
}