<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use ProgramCms\PostBundle\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $entity_id = null;

    #[ORM\Column(length: 255)]
    private ?string $customer_firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $customer_lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $customer_email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityId(): ?int
    {
        return $this->entity_id;
    }

    public function setEntityId(int $entity_id): self
    {
        $this->entity_id = $entity_id;

        return $this;
    }

    public function getCustomerFirstname(): ?string
    {
        return $this->customer_firstname;
    }

    public function setCustomerFirstname(string $customer_firstname): self
    {
        $this->customer_firstname = $customer_firstname;

        return $this;
    }

    public function getCustomerLastname(): ?string
    {
        return $this->customer_lastname;
    }

    public function setCustomerLastname(string $customer_lastname): self
    {
        $this->customer_lastname = $customer_lastname;

        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customer_email;
    }

    public function setCustomerEmail(string $customer_email): self
    {
        $this->customer_email = $customer_email;

        return $this;
    }
}
