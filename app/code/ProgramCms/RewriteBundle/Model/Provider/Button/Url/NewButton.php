<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Model\Provider\Button\Url;

use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class NewButton
 * @package ProgramCms\RewriteBundle\Model\Provider\Button\Url
 */
class NewButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * NewTemplateButton constructor.
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
            'buttonAction' => $this->url->getUrlByRouteName('rewrite_url_new'),
            'label' => 'New Url Rewrite'
        ];
    }
}