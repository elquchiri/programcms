<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Account;

use ProgramCms\CoreBundle\App\AreaInterface;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Mailer\Template\TransportBuilder;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ProgramCms\UserBundle\Security\LoginAuthenticator;
use ProgramCms\WebsiteBundle\Helper\Contact;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class ResetController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Account
 */
class ResetController extends Controller
{
    /**
     * @var LoginAuthenticator
     */
    protected LoginAuthenticator $loginAuthenticator;

    /**
     * @var UserAuthenticatorInterface
     */
    protected UserAuthenticatorInterface $userAuthenticator;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;
    protected TransportBuilder $transportBuilder;
    protected WebsiteManagerInterface $websiteManager;
    protected Contact $contactHelper;
    protected MailerInterface $mailer;

    /**
     * LoginAsUserController constructor.
     * @param Context $context
     * @param LoginAuthenticator $loginAuthenticator
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        LoginAuthenticator $loginAuthenticator,
        UserAuthenticatorInterface $userAuthenticator,
        UserEntityRepository $userRepository,
        TransportBuilder $transportBuilder,
        WebsiteManagerInterface $websiteManager,
        Contact $contactHelper,
        MailerInterface $mailer
    )
    {
        parent::__construct($context);
        $this->loginAuthenticator = $loginAuthenticator;
        $this->userAuthenticator = $userAuthenticator;
        $this->userRepository = $userRepository;
        $this->transportBuilder = $transportBuilder;
        $this->websiteManager = $websiteManager;
        $this->contactHelper = $contactHelper;
        $this->mailer = $mailer;
    }

    public function execute()
    {
        $userId = $this->getRequest()->getParam('id');
        if(!empty($userId)) {
            /** @var UserEntity $user */
            $user = $this->userRepository->getById($userId);
            if($user) {
                $this->sendRecoveryEmail($user);
            }
        }
        $this->addFlash('success', $this->trans('User Successfully Reset'));
        return $this->redirect($this->getUrl()->getUrlByRouteName('user_index_edit', ['id' => $userId]));
    }

    /**
     * @param UserEntity $user
     * @throws TransportExceptionInterface
     */
    private function sendRecoveryEmail(UserEntity $user)
    {
        $this->transportBuilder
            ->setTemplateId('recovery_email')
            ->setTemplateOptions([
                'area' => AreaInterface::AREA_ADMINHTML,
                'website_view' => $this->websiteManager->getWebsiteView()
            ])
            ->setTemplateVars(['user' => $user])
            ->setFrom($this->contactHelper->getSenderEmail('general_contact'))
            ->setTo([$user->getEmail()])
            ->setSubject($this->trans('ProgramCMS: Recovery Email'))
            ->sendMessage();
    }
}