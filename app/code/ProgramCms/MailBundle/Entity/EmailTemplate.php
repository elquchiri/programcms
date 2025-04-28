<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use Symfony\Component\Validator\Constraints\Unique;
use ProgramCms\MailBundle\Repository\EmailTemplateRepository;

/**
 * Class EmailTemplate
 * @package ProgramCms\MailBundle\Entity
 */
#[ORM\Entity(repositoryClass: EmailTemplateRepository::class)]
class EmailTemplate extends Entity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected ?int $entity_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $code;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    #[Unique]
    private ?string $name;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 300)]
    private ?string $subject;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    private ?string $content;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    private ?string $css;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    private ?string $html;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    private ?string $text;

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->entity_id;
    }

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId): static
    {
        $this->entity_id = $entityId;
        return $this;
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return $this
     */
    public function setHtml(string $html): static
    {
        $this->html = $html;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setCss(string $css): static
    {
        $this->css = $css;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCss(): ?string
    {
        return $this->css;
    }
}