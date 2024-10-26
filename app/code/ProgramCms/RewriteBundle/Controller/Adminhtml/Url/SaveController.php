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
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class SaveController
 * @package ProgramCms\RewriteBundle\Controller\Adminhtml\Url
 */
class SaveController extends AdminController
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var UrlRewriteRepository 
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param ObjectSerializer $objectSerializer
     * @param UrlRewriteRepository $urlRewriteRepository
     */
    public function __construct(
        Context $context,
        Url $url,
        ObjectSerializer $objectSerializer,
        UrlRewriteRepository $urlRewriteRepository
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->objectSerializer = $objectSerializer;
        $this->urlRewriteRepository = $urlRewriteRepository;
    }

    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->isMethod('POST')) {
            $urlRewriteId = $this->getRequest()->getParam('url_rewrite_id');
            $postData = $request->request->all();
            $urlRewrite = !empty($urlRewriteId) && $this->urlRewriteRepository->getById($urlRewriteId) ? $this->urlRewriteRepository->getById($urlRewriteId) :  new UrlRewrite();
            $this->objectSerializer->arrayToObject($urlRewrite, $postData);

            if(isset($postData['arguments_json'])) {
                if(!json_validate($postData['arguments_json'])) {
                    $this->addFlash('danger', $this->trans('Invalid Arguments Json Value.'));
                    return $this->redirect($this->url->getUrlByRouteName('rewrite_url_edit', ['id' => $urlRewrite->getUrlRewriteId()]));
                }
                $urlRewrite->setArguments($postData['arguments_json']);
            }

            $this->urlRewriteRepository->save($urlRewrite);
            $this->addFlash('success', $this->trans('URL Rewrite successfully saved.'));
            return $this->redirect($this->url->getUrlByRouteName('rewrite_url_edit', ['id' => $urlRewrite->getUrlRewriteId()]));
        }
        return $this->redirect($this->url->getUrlByRouteName('rewrite_url_index'));
    }
}