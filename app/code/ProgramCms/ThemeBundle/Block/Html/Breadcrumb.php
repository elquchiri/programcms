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
     * @var \ProgramCms\CoreBundle\View\Page\Breadcrumb
     */
    protected \ProgramCms\CoreBundle\View\Page\Breadcrumb $breadcrumb;

    /**
     * Breadcrumb constructor.
     * @param Template\Context $context
     * @param DataHelper $dataHelper
     * @param \ProgramCms\CoreBundle\View\Page\Breadcrumb $breadcrumb
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        DataHelper $dataHelper,
        \ProgramCms\CoreBundle\View\Page\Breadcrumb $breadcrumb,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->dataHelper = $dataHelper;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->dataHelper->isBreadcrumbEnabled();
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->breadcrumb->getItems();
    }

    /**
     * @param $html
     * @param int $length
     * @return string
     */
    public function getPreviewText($html, int $length = 25): string
    {
        return strlen($html) > $length ? substr($html, 0, $length) . ' ...' : $html;
    }
}