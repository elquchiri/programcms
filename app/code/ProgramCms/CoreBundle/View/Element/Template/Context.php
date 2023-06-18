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

    public function __construct(
        \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList,
        \ProgramCms\RouterBundle\Service\Request $request,
        \Twig\Environment $environment
    )
    {
        parent::__construct($directoryList, $request);
        $this->environment = $environment;
    }

    public function getEnvironment(): \Twig\Environment
    {
        return $this->environment;
    }
}