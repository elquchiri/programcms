<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Group;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\UserBundle\Repository\Group\UserGroupRepository;

/**
 * Class UserGroup
 * @package ProgramCms\UserBundle\Entity\Group
 */
#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
class UserGroup extends Entity
{
    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $code;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $label;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }
}