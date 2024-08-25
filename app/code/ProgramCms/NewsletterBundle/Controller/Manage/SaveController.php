<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Controller\Manage;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\NewsletterBundle\Entity\Newsletter;
use ProgramCms\NewsletterBundle\Repository\NewsletterRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;

/**
 * Class SaveController
 * @package ProgramCms\NewsletterBundle\Controller\Manage
 */
class SaveController extends Controller
{
    /**
     * @var NewsletterRepository
     */
    protected NewsletterRepository $newsletterRepository;

    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param NewsletterRepository $newsletterRepository
     * @param Security $security
     * @param WebsiteManagerInterface $websiteManager
     */
    public function __construct(
        Context $context,
        NewsletterRepository $newsletterRepository,
        Security $security,
        WebsiteManagerInterface $websiteManager
    )
    {
        parent::__construct($context);
        $this->newsletterRepository = $newsletterRepository;
        $this->security = $security;
        $this->websiteManager = $websiteManager;
    }

    public function execute()
    {
        $websiteView = $this->websiteManager->getWebsiteView();
        $newsletterSubscription = (bool)$this->getRequest()->getParam('newsletter_subscription');
        /** @var UserEntity $user */
        $user = $this->security->getUser();
        $newsletter = $this->newsletterRepository->findOneBy(['user' => $user]);
        if(is_null($newsletter)) {
            $newsletter = new Newsletter();
        }

        $newsletter
            ->setWebsiteView($websiteView)
            ->setUser($user)
            ->setSubscriberEmail($user->getEmail())
            ->setSubscriberStatus($newsletterSubscription)
            ->updateTimestamps();

        $this->newsletterRepository->save($newsletter);

        if($newsletterSubscription === true) {
            $this->addFlash('success', $this->trans("You are now subscribed to the newsletter."));
        }else{
            $this->addFlash('success', $this->trans("You are now unsubscribed to the newsletter."));
        }

        return $this->redirect(
            $this->url->getUrlByRouteName('newsletter_manage_index')
        );
    }
}