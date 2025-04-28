<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\PageBundle\Repository\PageRepository;
use ProgramCms\PageBundle\Api\PageInterface;

/**
 * Class PageEntity
 * @package ProgramCms\PageBundle\Entity
 */
#[ORM\Entity(repositoryClass: PageRepository::class)]
class PageEntity extends Entity implements PageInterface
{
    /**
     * @var string|null
     */
    #[ORM\Column(length: 190, unique: true, nullable: false)]
    private ?string $page_identifier;

    /**
     * @var EavAttributeSet|null
     */
    #[ORM\ManyToOne(targetEntity: EavAttributeSet::class)]
    #[ORM\JoinColumn(name: 'attribute_set_id', referencedColumnName: 'attribute_set_id', nullable: true)]
    private ?EavAttributeSet $attributeSet = null;

    /**
     * @var AdminUser|null
     */
    #[ORM\ManyToOne(targetEntity: AdminUser::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    private ?AdminUser $user;

    /**
     * PageEntity constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getPageIdentifier(): string
    {
        return $this->page_identifier;
    }

    /**
     * @param string $pageIdentifier
     * @return $this
     */
    public function setPageIdentifier(string $pageIdentifier): static
    {
        $this->page_identifier = $pageIdentifier;
        return $this;
    }

    /**
     * @return AdminUser|null
     */
    public function getUser(): ?AdminUser
    {
        return $this->user;
    }

    /**
     * @param AdminUser $user
     * @return $this
     */
    public function setUser(AdminUser $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return EavAttributeSet|null
     */
    public function getAttributeSet(): ?EavAttributeSet
    {
        return $this->attributeSet;
    }

    /**
     * @param EavAttributeSet $attributeSet
     * @return $this
     */
    public function setAttributeSet(EavAttributeSet $attributeSet): static
    {
        $this->attributeSet = $attributeSet;
        return $this;
    }
}
