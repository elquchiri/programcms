<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Decorator;

use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Helper\Config;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\RouterBundle\Service\UrlInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;

/**
 * Class UrlDecorator
 * @package ProgramCms\RewriteBundle\Decorator
 */
#[AsDecorator(
    decorates: Url::class,
    priority: 10
)]
class UrlDecorator implements UrlInterface
{
    /**
     * @var Url
     */
    protected Url $subject;

    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * UrlDecorator constructor.
     * @param Url $subject
     * @param UrlRewriteRepository $urlRewriteRepository
     * @param Config $config
     */
    public function __construct(
        #[MapDecorated] Url $subject,
        UrlRewriteRepository $urlRewriteRepository,
        Config $config
    )
    {
        $this->subject = $subject;
        $this->urlRewriteRepository = $urlRewriteRepository;
        $this->config = $config;
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function getUrlByRouteName($routeName, array $params = []): string
    {
        if($this->config->isRewriteEnabled()) {
            /** @var UrlRewrite $urlRewrite */
            $rewriteParams = [];
            $urlRewrite = $this->urlRewriteRepository->getByTargetPath($routeName, $params);
            if ($urlRewrite) {
                if(!empty($params)) {
                    ksort($params);
                }
                if(!empty($urlRewrite->getArguments())) {
                    $rewriteParams = json_decode($urlRewrite->getArguments(), true);
                    ksort($rewriteParams);
                }

                if ($rewriteParams === $params) {
                    return '/' . $urlRewrite->getRequestPath();
                }
            }
        }

        return $this->subject->getUrlByRouteName($routeName, $params);
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->subject->getBaseUrl();
    }

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->subject->getRouteName();
    }

    /**
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->subject->getCurrentUrl();
    }

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public function getUrl(string $routeName, array $params = []): string
    {
        return $this->subject->getUrl($routeName, $params);
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function getUrlByFullRouteName($routeName, array $params = []): string
    {
        return $this->subject->getUrlByFullRouteName($routeName, $params);
    }
}