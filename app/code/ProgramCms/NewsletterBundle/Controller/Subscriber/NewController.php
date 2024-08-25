<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Controller\Subscriber;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\NewsletterBundle\Entity\Newsletter;
use ProgramCms\NewsletterBundle\Repository\NewsletterRepository;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;

/**
 * Class NewController
 * @package ProgramCms\NewsletterBundle\Controller\Subscriber
 */
class NewController extends Controller
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
     * NewController constructor.
     * @param Context $context
     * @param NewsletterRepository $newsletterRepository
     * @param WebsiteManagerInterface $websiteManager
     */
    public function __construct(
        Context $context,
        NewsletterRepository $newsletterRepository,
        WebsiteManagerInterface $websiteManager
    )
    {
        parent::__construct($context);
        $this->newsletterRepository = $newsletterRepository;
        $this->websiteManager = $websiteManager;
    }

    public function execute()
    {
        $websiteView = $this->websiteManager->getWebsiteView();
        $email = $this->getRequest()->getParam('newsletter_email');
        if(empty($email)) {
            $this->addFlash('danger', $this->trans('Invalid Email Address, please provide a valid email.'));
            return $this->redirect(
                $this->url->getUrlByRouteName('cms_index_index')
            );
        }

        $emailExists = $this->newsletterRepository->findOneBy(['subscriber_email' => $email]);
        if(!is_null($emailExists)) {
            $this->addFlash('danger', $this->trans("You're already subscribed to the newsletter."));
            return $this->redirect(
                $this->url->getUrlByRouteName('cms_index_index')
            );
        }

        $newsletter = new Newsletter();
        $newsletter
            ->setWebsiteView($websiteView)
            ->setSubscriberEmail($email)
            ->setSubscriberStatus(true)
            ->updateTimestamps();

        $this->newsletterRepository->save($newsletter);

        $this->addFlash('success', $this->trans("You are now subscribed to the newsletter."));
        return $this->redirect(
            $this->url->getUrlByRouteName('cms_index_index')
        );
    }
}