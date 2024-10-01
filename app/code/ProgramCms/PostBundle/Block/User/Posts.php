<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block\User;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Posts
 * @package ProgramCms\PostBundle\Block\User
 */
class Posts extends Template
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * Posts constructor.
     * @param Template\Context $context
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->security = $security;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->security->getUser();
    }

    /**
     * @return bool
     */
    public function hasPosts(): bool
    {
        return !$this->getUser()->getPosts()->isEmpty();
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->getUser()->getPosts();
    }

    /**
     * @param $html
     * @param $length
     * @return string
     */
    public function getPreviewText($html, $length): string
    {
        return strlen($html) > $length ? substr($html, 0, $length) . ' ...' : $html;
    }
}