<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Entity;

use DateTime;
use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Repository\AdminMessageRepository;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdminMessage
 * @package ProgramCms\AdminChatBundle\Entity
 */
#[ORM\Entity(repositoryClass: AdminMessageRepository::class)]
class AdminMessage extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $message_id;

    /**
     * @var AdminUser
     */
    #[ORM\ManyToOne(targetEntity: AdminUser::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    private AdminUser $user;

    /**
     * @var AdminConversation
     */
    #[ORM\ManyToOne(targetEntity: AdminConversation::class)]
    #[ORM\JoinColumn(name: 'conversation_id', referencedColumnName: 'conversation_id')]
    private AdminConversation $conversation;

    /**
     * @var string
     */
    #[ORM\Column(type: 'text')]
    private string $message;

    /**
     * @var DateTime|null
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $created_at = null;

    /**
     * @var DateTime|null
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $updated_at = null;

    /**
     * @param int $message_id
     * @return $this
     */
    public function setMessageId(int $message_id): self
    {
        $this->message_id = $message_id;
        return $this;
    }

    public function getMessageId(): ?int
    {
        return $this->message_id;
    }

    /**
     * @param AdminUser $user
     * @return $this
     */
    public function setUser(AdminUser $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return AdminUser
     */
    public function getUser(): AdminUser
    {
        return $this->user;
    }

    /**
     * @param AdminConversation $conversation
     * @return $this
     */
    public function setConversation(AdminConversation $conversation): self
    {
        $this->conversation = $conversation;
        return $this;
    }

    /**
     * @return AdminConversation
     */
    public function getConversation(): AdminConversation
    {
        return $this->conversation;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime|null $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt = null): self
    {
        $this->created_at = $createdAt ?? new DateTime();
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt = null): self
    {
        $this->updated_at = $updatedAt ?? new DateTime();
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(): void
    {
        $now = new DateTime();
        $this->setUpdatedAt($now);
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($now);
        }
    }
}