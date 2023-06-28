<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Account;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\UserBundle\Entity\User;
use ProgramCms\UserBundle\Form\UserRegistrationType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class RegisterController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class RegisterController extends \ProgramCms\CoreBundle\Controller\Controller
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
    )
    {
        parent::__construct($request, $response);
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

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

        return $this->getResponse()->render();
    }
}