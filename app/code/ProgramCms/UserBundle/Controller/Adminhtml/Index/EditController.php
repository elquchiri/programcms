<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UserBundle\Repository\UserRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EditController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class EditController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;
    protected UserRepository $userRepository;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param UserRepository $userRepository
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        UserRepository $userRepository,
        TranslatorInterface $translator
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->translator = $translator;
        $this->userRepository = $userRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $user = $this->userRepository->findOneBy(['id' => $this->getRequest()->getParam('id')]);
        if($user) {
            $pageResult->getConfig()->getTitle()->set(
                $this->translator->trans($user->getFullName())
            );
        }
        return $pageResult;
    }
}