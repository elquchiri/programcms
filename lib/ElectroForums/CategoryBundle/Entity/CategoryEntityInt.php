<?php


namespace ElectroForums\CategoryBundle\Entity;


use ElectroForums\CategoryBundle\Repository\CategoryEntityIntRepository;
use Doctrine\ORM\Mapping as ORM;

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