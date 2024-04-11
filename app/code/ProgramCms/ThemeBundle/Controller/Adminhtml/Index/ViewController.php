<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use ReflectionException;

/**
 * Class ViewController
 * @package ProgramCms\ThemeBundle\Controller\Adminhtml\Index
 */
class ViewController extends \ProgramCms\CoreBundle\Controller\AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * ViewController constructor.
     * @param Context $context
     * @param Request $request
     * @param ThemeRepository $themeRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        Request $request,
        ThemeRepository $themeRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->themeRepository = $themeRepository;
        $this->request = $request;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute(): ?object
    {
        $themeId = $this->request->getParam('id');
        $theme = $this->themeRepository->getById($themeId);
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set(
            sprintf($this->trans("%s"), $theme->getThemeTitle())
        );
        return $pageResult;
    }
}