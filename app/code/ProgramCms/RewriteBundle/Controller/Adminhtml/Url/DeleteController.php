<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Controller\Adminhtml\Url;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;

/**
 * Class DeleteController
 * @package ProgramCms\RewriteBundle\Controller\Adminhtml\Url
 */
class DeleteController extends AdminController
{
    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * DeleteController constructor.
     * @param Context $context
     * @param UrlRewriteRepository $urlRewriteRepository
     */
    public function __construct(
        Context $context,
        UrlRewriteRepository $urlRewriteRepository
    )
    {
        parent::__construct($context);
        $this->urlRewriteRepository = $urlRewriteRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $urlId = (int) $this->getRequest()->getParam('id');
        /** @var UrlRewrite $urlRewrite */
        $urlRewrite = $this->urlRewriteRepository->getById($urlId);
        if($urlRewrite) {
            $this->urlRewriteRepository->remove($urlRewrite, true);
        }
        return $this->redirect($this->url->getUrlByRouteName('rewrite_url_index'));
    }
}