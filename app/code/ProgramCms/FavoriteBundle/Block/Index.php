<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\FavoriteBundle\Block;

use DateTime;
use ProgramCms\CoreBundle\DateTime\Transformer;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\FavoriteBundle\Entity\Favorite;
use ProgramCms\FavoriteBundle\Repository\FavoriteRepository;
use ProgramCms\PostBundle\Entity\PostEntity;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Index
 * @package ProgramCms\FavoriteBundle\Block
 */
class Index extends Template
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var FavoriteRepository
     */
    protected FavoriteRepository $favoriteRepository;

    /**
     * @var Transformer
     */
    protected Transformer $dateTimeTransformer;

    /**
     * Index constructor.
     * @param Template\Context $context
     * @param Security $security
     * @param FavoriteRepository $favoriteRepository
     * @param Transformer $dateTimeTransformer
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Security $security,
        FavoriteRepository $favoriteRepository,
        Transformer $dateTimeTransformer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->security = $security;
        $this->favoriteRepository = $favoriteRepository;
        $this->dateTimeTransformer = $dateTimeTransformer;
    }

    /**
     * @return array
     */
    public function getFavoritePosts(): array
    {
        $user = $this->security->getUser();
        return $this->favoriteRepository->findBy([
            'user' => $user
        ]);
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

    /**
     * @param Favorite $favorite
     * @return string
     */
    public function getPostUrl(Favorite $favorite): string
    {
        return $this->getUrl('post_index_view', [
            'id' => $favorite->getPost()->getEntityId(),
            'category' => $favorite->getCategory()->getEntityId()
        ]);
    }

    /**
     * @param DateTime $dateTime
     * @return string
     */
    public function getTimeAgo(DateTime $dateTime): string
    {
        return $this->dateTimeTransformer->timeAgo($dateTime);
    }

    /**
     * @param Favorite $favorite
     * @return string
     */
    public function getRemoveFavoriteUrl(Favorite $favorite): string
    {
        return $this->getUrl('favorite_index_remove', ['favorite' => $favorite->getEntityId()]);
    }
}