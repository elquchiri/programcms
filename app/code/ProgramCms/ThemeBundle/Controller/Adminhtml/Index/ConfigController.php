<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class IndexController
 * @package ProgramCms\ThemeBundle\Controller\Adminhtml\Index
 */
class ConfigController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param Url $url
     */
    public function __construct(
        Context $context,
        Url $url
    )
    {
        parent::__construct($context);
        $this->url = $url;
    }

    /**
     * Redirect to Theme Configuration route
     * @return object|null
     */
    public function execute(): ?object
    {
        return $this->redirect(
            $this->url->getUrlByRouteName('config_systemconfig_edit', ['section' => 'theme_config'])
        );
    }
}