<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\SystemAccount;

use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\RouterBundle\Service\Url;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SaveController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\SystemAccount
 */
class SaveController extends \ProgramCms\CoreBundle\Controller\AdminController
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $passwordHasher;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param AdminUserRepository $adminUserRepository
     * @param Security $security
     * @param TranslatorInterface $translator
     * @param UserPasswordHasherInterface $passwordHasher
     * @param Url $url
     */
    public function __construct(
        Context $context,
        AdminUserRepository $adminUserRepository,
        Security $security,
        TranslatorInterface $translator,
        UserPasswordHasherInterface $passwordHasher,
        Url $url
    )
    {
        parent::__construct($context);
        $this->translator = $translator;
        $this->adminUserRepository = $adminUserRepository;
        $this->security = $security;
        $this->url = $url;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->getMethod() == 'POST') {
            $id = $this->security->getUser()->getUserIdentifier();
            $user = $this->adminUserRepository->getByEmail($id);
            $formData = $request->request->all();

            if (!$this->passwordHasher->isPasswordValid($user, $formData['password'])) {
                // Flash error message and redirect
                $this->addFlash('danger',
                    $this->translator->trans('The provided password is not valid, please try again.')
                );
                return $this->redirect($this->url->getUrlByRouteName('admin_systemaccount_index'));
            }

            $user->setFirstName($formData['first_name'])
                ->setLastName($formData['last_name'])
                ->setEmail($formData['email'])
                ->setInterfaceLocale($formData['interface_locale']);

            // Save User Data
            $this->adminUserRepository->save($user, true);
            // Flash success message and redirect
            $this->addFlash('success',
                $this->translator->trans('Account Successfully Saved.')
            );
            return $this->redirect($this->url->getUrlByRouteName('admin_systemaccount_index'));
        }
    }
}