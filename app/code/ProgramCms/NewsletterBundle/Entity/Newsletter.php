<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use \ProgramCms\NewsletterBundle\Repository\NewsletterRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use Symfony\Component\Validator\Constraints\Unique;

/**
 * Class Newsletter
 * @package ProgramCms\NewsletterBundle\Entity
 */
#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter extends Entity
{
    #[ORM\ManyToOne(targetEntity: WebsiteView::class)]
    #[ORM\JoinColumn(name: 'website_view', referencedColumnName: 'website_view_id')]
    private WebsiteView $websiteView;

    /**
     * @var UserEntity
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private UserEntity $user;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Unique]
    private ?string $subscriber_email = null;

    /**
     * @var bool
     */
    #[ORM\Column(length: 255)]
    #[Unique]
    private ?bool $subscriber_status = null;

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function setWebsiteView(WebsiteView $websiteView): static
    {
        $this->websiteView = $websiteView;
        return $this;
    }

    /**
     * @return WebsiteView
     */
    public function getWebsiteView(): WebsiteView
    {
        return $this->websiteView;
    }

    /**
     * @param UserEntity $user
     * @return $this
     */
    public function setUser(UserEntity $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @param string $subscriberEmail
     * @return $this
     */
    public function setSubscriberEmail(string $subscriberEmail): static
    {
        $this->subscriber_email = $subscriberEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubscriberEmail(): ?string
    {
        return $this->subscriber_email;
    }

    /**
     * @param bool $subscriberStatus
     * @return $this
     */
    public function setSubscriberStatus(bool $subscriberStatus): static
    {
        $this->subscriber_status = $subscriberStatus;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSubscriberStatus(): ?bool
    {
        return $this->subscriber_status;
    }
}
