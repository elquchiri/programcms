<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Entity;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdminConversation
 * @package ProgramCms\AdminChatBundle\Entity
 */
#[ORM\Entity(repositoryClass: AdminConversationRepository::class)]
class AdminConversation extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $conversation_id;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 250)]
    private ?string $title;

    /**
     * @var ArrayCollection
     */
    #[ORM\JoinTable(name: 'admin_conversation_user_relation')]
    #[ORM\ManyToMany(targetEntity: AdminUser::class, inversedBy: 'conversations')]
    #[ORM\JoinColumn(name: 'conversation_id', referencedColumnName: 'conversation_id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    private Collection $users;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'conversation', targetEntity: AdminMessage::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $messages;

    /**
     * Conversation constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getConversationId(): ?int
    {
        return $this->conversation_id;
    }

    /**
     * @param $conversation_id
     * @return $this
     */
    public function setConversationId($conversation_id): self
    {
        $this->conversation_id = $conversation_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param ArrayCollection $users
     * @return $this
     */
    public function setUsers(ArrayCollection $users): self
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param AdminUser $user
     * @return $this
     */
    public function addUser(AdminUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addConversation($this);
        }

        return $this;
    }

    /**
     * @param AdminUser $user
     */
    public function removeUser(AdminUser $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @param AdminMessage $message
     * @return $this
     */
    public function addMessage(AdminMessage $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversation($this);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $messages
     * @return $this
     */
    public function setMessages(ArrayCollection $messages): self
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }
}