<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\User;

use ProgramCms\CoreBundle\DateTime\TransformerInterface;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class About
 * @package ProgramCms\UserBundle\Block\User
 */
class About extends AbstractUser
{
    /**
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;

    /**
     * About constructor.
     * @param Template\Context $context
     * @param UserEntityRepository $userRepository
     * @param TransformerInterface $transformer
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        UserEntityRepository $userRepository,
        TransformerInterface $transformer,
        array $data = []
    )
    {
        parent::__construct($context, $userRepository, $data);
        $this->transformer = $transformer;
    }

    /**
     * @return string
     */
    public function getUserCreationTime(): string
    {
        return $this->transformer->transform($this->getUser()->getCreatedAt());
    }
}