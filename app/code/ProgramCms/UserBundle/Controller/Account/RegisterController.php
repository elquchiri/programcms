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
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Entity\Group\UserGroup;
use ProgramCms\UserBundle\Entity\UserEntity as User;
use ProgramCms\UserBundle\Model\Validation\RegisterValidatorInterface;
use ProgramCms\UserBundle\Repository\Group\UserGroupRepository;
use ProgramCms\UserBundle\Security\LoginAuthenticator;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use ProgramCms\UserBundle\Helper\Config as UserConfigHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use ReflectionException;

/**
 * Class RegisterController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class RegisterController extends Controller
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
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * @var RegisterValidatorInterface
     */
    protected RegisterValidatorInterface $validator;

    /**
     * @var UserAuthenticatorInterface
     */
    protected UserAuthenticatorInterface $userAuthenticator;

    /**
     * @var LoginAuthenticator
     */
    protected LoginAuthenticator $loginAuthenticator;

    /**
     * @var UserConfigHelper
     */
    protected UserConfigHelper $userConfigHelper;

    /**
     * @var UserGroupRepository
     */
    protected UserGroupRepository $userGroupRepository;

    /**
     * RegisterController constructor.
     * @param Context $context
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param ObjectManager $objectManager
     * @param WebsiteManagerInterface $websiteManager
     * @param RegisterValidatorInterface $validator
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param LoginAuthenticator $loginAuthenticator
     * @param UserConfigHelper $userConfigHelper
     * @param UserGroupRepository $userGroupRepository
     */
    public function __construct(
        Context $context,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        ObjectManager $objectManager,
        WebsiteManagerInterface $websiteManager,
        RegisterValidatorInterface $validator,
        UserAuthenticatorInterface $userAuthenticator,
        LoginAuthenticator $loginAuthenticator,
        UserConfigHelper $userConfigHelper,
        UserGroupRepository $userGroupRepository
    )
    {
        parent::__construct($context);
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->request = $context->getRequest();
        $this->objectManager = $objectManager;
        $this->websiteManager = $websiteManager;
        $this->validator = $validator;
        $this->userAuthenticator = $userAuthenticator;
        $this->loginAuthenticator = $loginAuthenticator;
        $this->userConfigHelper = $userConfigHelper;
        $this->userGroupRepository = $userGroupRepository;
    }

    /**
     * @return object|RedirectResponse|null
     * @throws ReflectionException
     */
    public function execute()
    {
        if ($this->getSecurity()->getUser()) {
            return $this->redirect($this->url->getUrlByRouteName('cms_index_index'));
        }

        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Create an Account")
        );

        // Create a new User instance
        $user = new User();

        if ($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $currentWebsiteView = $this->websiteManager->getWebsiteView();
            $data = [
                'email' => $this->getRequest()->getParam('email'),
                'password' => $this->getRequest()->getParam('password'),
                'username' => $this->getRequest()->getParam('username'),
                'user_firstname' => $this->getRequest()->getParam('user_firstname'),
                'user_lastname' => $this->getRequest()->getParam('user_lastname'),
                'user_country' => $this->getRequest()->getParam('user_country')
            ];
            $user->setEmail($data['email'])
                ->setPassword($data['password'])
                ->setUserName($data['username'])
                ->setUserFirstname($data['user_firstname'])
                ->setUserLastname($data['user_lastname'])
                ->setWebsiteView($currentWebsiteView)
                ->updateTimestamps();

            $errors = $this->validator->validate($user, $data);
            // If no errors found, create the user
            if(count($errors) === 0) {
                // encode the plain password
                $user->setPassword(
                    $this->userPasswordHasher->hashPassword($user, $data['password'])
                );
                // Set Default Account Role
                /** @var UserGroup $defaultGroup */
                $defaultGroup = $this->userGroupRepository->getByGroupCode('ROLE_USER');
                $user->setGroups([$defaultGroup]);

                // Set Default Address
                $defaultAddress = new UserAddressEntity();
                $defaultAddress
                    ->setUser($user)
                    ->setIsActive(true)
                    ->setCountryCode($data['user_country'])
                    ->updateTimestamps();
                $user->setDefaultAddress($defaultAddress);

                // Save User
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->addFlash('success', $this->trans('Your account has been created successfully.'));
                $this->authenticateUser($user);

                if($this->userConfigHelper->shouldRedirectUserAfterLogin()) {
                    return $this->redirectToRoute('frontend_user_edit_index');
                }
                return $this->redirectToRoute('frontend_cms_index_index');
            }else{
                // Prepare error messages
                $errorMessages = "<p>" . $this->trans('Please review the following information:') . "</p>";
                $errorMessages .= "<ul class='m-0'>";
                foreach($errors as $error) {
                    $errorMessages .= "<li>" . $error . "</li>";
                }
                $errorMessages .= "</ul>";

                // Flash merged error messages
                $this->addFlash('danger', $errorMessages);
            }
        }

        // Pass user object to the registration form block
        $pageResult->getLayout()->getBlock('user.register.form')->setData('user', $user);

        return $pageResult;
    }

    /**
     * @param User $user
     */
    public function authenticateUser(User $user)
    {
        $this->userAuthenticator->authenticateUser($user, $this->loginAuthenticator, $this->getRequest()->getCurrentRequest());
    }
}