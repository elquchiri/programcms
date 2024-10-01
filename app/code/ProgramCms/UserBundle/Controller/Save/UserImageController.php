<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Save;

use Gedmo\Sluggable\Util\Urlizer;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class UserImageController
 * @package ProgramCms\UserBundle\Controller\Save
 */
class UserImageController extends Controller
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * UserImageController constructor.
     * @param Context $context
     * @param Security $security
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        Security $security,
        UserEntityRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    public function execute()
    {
        /** @var UserEntity $user */
        $user = $this->security->getUser();
        $rootDirectory = $this->getParameter('kernel.project_dir');
        $image = $this->getRequest()->getCurrentRequest()->files->get('profile_photo');
        $response = ['success' => false];
        if ($image->isValid()) {
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $image->guessExtension();
            $destination = $rootDirectory . '/public/media/user_entity/profile_image';
            $image->move($destination, $newFilename);
            $publicFileName = $this->url->getBaseUrl() . '/media/user_entity/profile_image/' . $newFilename;
            $user->setData('profile_image', $publicFileName);
            $user->setUpdatedAt();
            $this->userRepository->save($user);
            $response['success'] = true;
        }
        return $this->json($response);
    }
}