<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;
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
    #[ORM\Column(type: 'string')]
    private ?string $html;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    private ?string $text;
}