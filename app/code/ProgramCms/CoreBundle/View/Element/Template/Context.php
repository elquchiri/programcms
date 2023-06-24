<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Context
 * @package ProgramCms\CoreBundle\View\Element\Template
 */
class Context extends \ProgramCms\CoreBundle\View\Element\Context
{

    protected \Twig\Environment $environment;
    protected \ProgramCms\RouterBundle\Service\Url $url;
    protected \ProgramCms\CoreBundle\View\Page\Config $pageConfig;

    public function __construct(
        \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList,
        \ProgramCms\RouterBundle\Service\Request $request,
        \Twig\Environment $environment,
        \ProgramCms\RouterBundle\Service\Url $url,
        \ProgramCms\CoreBundle\View\Page\Config $pageConfig
    )
    {
        parent::__construct($directoryList, $request);
        $this->environment = $environment;
        $this->url = $url;
        $this->pageConfig = $pageConfig;
    }

    public function getEnvironment(): \Twig\Environment
    {
        return $this->environment;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPageConfig(): \ProgramCms\CoreBundle\View\Page\Config
    {
        return $this->pageConfig;
    }
}