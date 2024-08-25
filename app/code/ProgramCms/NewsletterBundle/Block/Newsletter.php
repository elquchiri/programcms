<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\NewsletterBundle\Helper\Data as NewsletterDataHelper;
use ProgramCms\NewsletterBundle\Repository\NewsletterRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Newsletter
 * @package ProgramCms\NewsletterBundle\Block
 */
class Newsletter extends Template
{
    /**
     * @var NewsletterDataHelper
     */
    protected NewsletterDataHelper $newsletterDataHelper;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var NewsletterRepository
     */
    protected NewsletterRepository $newsletterRepository;

    /**
     * Newsletter constructor.
     * @param Template\Context $context
     * @param NewsletterDataHelper $newsletterDataHelper
     * @param Security $security
     * @param NewsletterRepository $newsletterRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        NewsletterDataHelper $newsletterDataHelper,
        Security $security,
        NewsletterRepository $newsletterRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->newsletterDataHelper = $newsletterDataHelper;
        $this->security = $security;
        $this->newsletterRepository = $newsletterRepository;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->newsletterDataHelper->isNewsletterEnabled();
    }

    /**
     * @return string
     */
    public function getSaveNewsletterUrl(): string
    {
        return $this->getUrl('newsletter_manage_save');
    }

    /**
     * @return string
     */
    public function getSubmitNewsletterUrl(): string
    {
        return $this->getUrl('newsletter_subscriber_new');
    }

    /**
     * @return bool
     */
    public function isUserSubscribed(): bool
    {
        /** @var UserEntity $user */
        $user = $this->security->getUser();
        $newsletter = $this->newsletterRepository->findOneBy([
            'subscriber_email' => $user->getEmail(),
            'subscriber_status' => true
        ]);
        return $newsletter != null;
    }
}