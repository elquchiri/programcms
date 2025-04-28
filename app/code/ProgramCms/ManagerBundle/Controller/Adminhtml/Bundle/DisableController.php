<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Controller\Adminhtml\Bundle;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Entity\Bundle;
use ProgramCms\CoreBundle\Repository\BundleRepository;

/**
 * Class DisableController
 * @package ProgramCms\ManagerBundle\Controller\Adminhtml\Bundle
 */
class DisableController extends AdminController
{
    /**
     * @var BundleRepository
     */
    protected BundleRepository $bundleRepository;

    /**
     * DisableController constructor.
     * @param Context $context
     * @param BundleRepository $bundleRepository
     */
    public function __construct(
        Context $context,
        BundleRepository $bundleRepository
    )
    {
        parent::__construct($context);
        $this->bundleRepository = $bundleRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Bundle $bundle */
        $bundle = $this->bundleRepository->getById($id);
        if($bundle) {
            $bundle->setStatus(false);
        }
        $this->bundleRepository->save($bundle);

        $this->addFlash('success', $this->trans('%s was successfully disabled', $bundle->getBundleName()));
        return $this->redirect($this->getUrl()->getUrlByRouteName('manager_bundle_index'));
    }
}