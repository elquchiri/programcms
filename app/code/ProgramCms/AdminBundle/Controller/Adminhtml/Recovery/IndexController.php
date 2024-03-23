<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\Recovery;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use ReflectionException;

/**
 * Class IndexController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\Recovery
 */
class IndexController extends AdminController
{
    use TargetPathTrait;

    const FIREWALL_NAME = 'admin';

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        // Reset target path session, to prevent redirection to recovery page after login
        $this->removeTargetPath($this->getRequest()->getCurrentRequest()->getSession(), self::FIREWALL_NAME);

        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Recover account")
        );
        return $pageResult;
    }
}