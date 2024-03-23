<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Recovery;

use ProgramCms\CoreBundle\App\AreaInterface;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Mailer\Template\TransportBuilder;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ProgramCms\WebsiteBundle\Helper\Contact;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class VerifyUserController
 * @package ProgramCms\UserBundle\Controller\Recovery
 */
class VerifyUserController extends Controller
{
    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * @var TokenGeneratorInterface
     */
    protected TokenGeneratorInterface $tokenGenerator;

    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $transportBuilder;

    /**
     * @var Contact
     */
    protected Contact $contactHelper;

    /**
     * RecoveryController constructor.
     * @param Context $context
     * @param ValidatorInterface $validator
     * @param UserEntityRepository $userEntityRepository
     * @param TokenGeneratorInterface $tokenGenerator
     * @param TransportBuilder $transportBuilder
     * @param WebsiteManagerInterface $websiteManager
     * @param Contact $contactHelper
     */
    public function __construct(
        Context $context,
        ValidatorInterface $validator,
        UserEntityRepository $userEntityRepository,
        TokenGeneratorInterface $tokenGenerator,
        TransportBuilder $transportBuilder,
        WebsiteManagerInterface $websiteManager,
        Contact $contactHelper
    )
    {
        parent::__construct($context);
        $this->validator = $validator;
        $this->userEntityRepository = $userEntityRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->transportBuilder = $transportBuilder;
        $this->websiteManager = $websiteManager;
        $this->contactHelper = $contactHelper;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        if($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $email = $this->getRequest()->getParam('email');
            $user = $this->userEntityRepository->getByEmail($email);
            if(!$user) {
                // Provided Email is not registered
                return $this->json([
                    'success' => false,
                    'message' => $this->trans('Provided Email is not registered with us.')
                ]);
            }

            try {
                // Generate & Save Recovery Token
                $user->setResetToken($this->tokenGenerator->generateToken());
                $this->userEntityRepository->save($user);
                // Send Recovery Email
                $this->transportBuilder
                    ->setTemplateId('recovery_email')
                    ->setTemplateOptions([
                        'area' => AreaInterface::AREA_FRONTEND,
                        'website_view' => $this->websiteManager->getWebsiteView()
                    ])
                    ->setTemplateVars(['user' => $user])
                    ->setFrom($this->contactHelper->getSenderEmail('general_contact'))
                    ->setTo([$email])
                    ->setSubject($this->trans('ProgramCMS: Recovery Email'))
                    ->sendMessage();
            }catch(TransportExceptionInterface $exception) {
                return $this->json([
                    'success' => false,
                    'message' => $this->trans("We're unable to send you the recovery token.")
                ]);
            }

            return $this->json([
                'success' => true,
                'message' => $this->trans('A secret number has been sent to your email. Please copy this number and then use it to complete the account recovery process.')
            ]);
        }

        return $this->json([
            'success' => false
        ]);
    }
}