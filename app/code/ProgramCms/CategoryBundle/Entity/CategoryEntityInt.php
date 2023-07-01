<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Entity;

use ProgramCms\CategoryBundle\Repository\CategoryEntityIntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryEntityInt
 * @package ProgramCms\CategoryBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityIntRepository::class)]
class CategoryEntityInt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $value_id = null;

    #[ORM\Column]
    private ?int $attribute_id = null;

    #[ORM\Column]
    private ?int $website_view_id = null;

    #[ORM\Column]
    private ?int $entity_id = null;

    #[ORM\Column]
    private ?int $value = null;
}