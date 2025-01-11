<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\PageBundle\Repository\PageRepository;

/**
 * Class Page
 * @package ProgramCms\PageBundle\Block
 */
class Page extends Template
{
    /**
     * @var PageRepository
     */
    protected PageRepository $pageRepository;

    /**
     * Page constructor.
     * @param Template\Context $context
     * @param PageRepository $pageRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PageRepository $pageRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return object|null
     */
    public function getPage()
    {
        $pageId = $this->getRequest()->getParam('id');
        return $this->pageRepository->getById($pageId);
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        /** @var PageEntity $page */
        $page = $this->getPage();
        $html = "<link rel=\"stylesheet\" href=\"https://cdn.plyr.io/3.7.8/plyr.css\"/>";
        $html .= "<div data-controller=\"post-viewer\">";
        $html .= "<style>". $page->getPageCss() ."</style>";
        $html .= $this->formatPost($page->getPageHtml());
        $html .= "</div>";
        return $html;
    }

    /**
     * @param string $fullHtml
     * @return string
     */
    public function formatPost(string $fullHtml): string
    {
        return preg_replace('/<body[^>]*>(.*?)<\/body>/is', '$1', $fullHtml);
    }
}