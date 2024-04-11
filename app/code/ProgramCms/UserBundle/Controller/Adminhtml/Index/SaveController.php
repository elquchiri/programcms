<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\RouterBundle\Service\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SaveController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class SaveController extends AdminController
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * SaveController constructor.
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
     * @return RedirectResponse
     */
    public function execute()
    {
        if($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $userId = (bool) $this->getRequest()->getParam('entity_id');
            if($userId) {
                $this->addFlash('success', $this->trans('User Successfully Saved.'));
                return $this->redirect($this->url->getUrlByRouteName('user_index_edit', ['id' => $userId]));
            }
        }
        return $this->redirect($this->url->getUrlByRouteName('user_index_index'));
    }
}