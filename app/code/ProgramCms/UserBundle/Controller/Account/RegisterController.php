<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Account;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\UserBundle\Entity\UserEntity as User;
use ProgramCms\UserBundle\Form\UserRegistrationType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class RegisterController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class RegisterController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * RegisterController constructor.
     * @param Context $context
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->request = $context->getRequest();
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|RedirectResponse|null
     */
    public function execute()
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            // Set Account Role as 'USER'
            $user->setRoles(['USER']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('frontend_home');
        }

        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set("Create Account");
        return $pageResult;
    }
}