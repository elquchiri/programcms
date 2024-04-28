<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Html;

use ProgramCms\AdminBundle\Helper\Data as DataHelper;
use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Breadcrumb
 * @package ProgramCms\ThemeBundle\Block\Html
 */
class Breadcrumb extends Template
{
    /**
     * @var DataHelper
     */
    protected DataHelper $dataHelper;

    /**
     * Breadcrumb constructor.
     * @param Template\Context $context
     * @param DataHelper $dataHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        DataHelper $dataHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->dataHelper->isBreadcrumbEnabled();
    }
}