<?php


namespace ElectroForums\CategoryBundle\Entity;


use ElectroForums\CategoryBundle\Repository\CategoryEntityTextRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryEntityTextRepository::class)]
class CategoryEntityText
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

    #[ORM\Column(length: 255)]
    private ?string $value = null;
}