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
     * RecoveryController constructor.
     * @param Context $context
     * @param ValidatorInterface $validator
     * @param UserEntityRepository $userEntityRepository
     * @param TokenGeneratorInterface $tokenGenerator
     * @param TransportBuilder $transportBuilder
     * @param WebsiteManagerInterface $websiteManager
     */
    public function __construct(
        Context $context,
        ValidatorInterface $validator,
        UserEntityRepository $userEntityRepository,
        TokenGeneratorInterface $tokenGenerator,
        TransportBuilder $transportBuilder,
        WebsiteManagerInterface $websiteManager,
    )
    {
        parent::__construct($context);
        $this->validator = $validator;
        $this->userEntityRepository = $userEntityRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->transportBuilder = $transportBuilder;
        $this->websiteManager = $websiteManager;
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
                    ->setFrom('contact@programcms.com')
                    ->setTo([$email])
                    ->setSubject('ProgramCMS: Recovery Email')
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