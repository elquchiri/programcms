<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Recovery;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Recovery
 * @package ProgramCms\AdminBundle\Block\Recovery
 */
class Recovery extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Recovery constructor.
     * @param Context $context
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Context $context,
        Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
    }
    /**
     * @return string
     */
    public function getAdminLoginUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_index_index');
    }
}