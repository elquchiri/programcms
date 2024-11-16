<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Model\Provider\Button\Url;

use ProgramCms\CoreBundle\App\RequestInterface;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;
use ProgramCms\RouterBundle\Service\UrlInterface;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class DeleteButton
 * @package ProgramCms\RewriteBundle\Model\Provider\Button\Url
 */
class DeleteButton implements ButtonProviderInterface
{
    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * DeleteButton constructor.
     * @param UrlRewriteRepository $urlRewriteRepository
     * @param UrlInterface $url
     * @param RequestInterface $request
     */
    public function __construct(
        UrlRewriteRepository $urlRewriteRepository,
        UrlInterface $url,
        RequestInterface $request
    )
    {
        $this->urlRewriteRepository = $urlRewriteRepository;
        $this->url = $url;
        $this->request = $request;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        $urlId = $this->request->getParam('id');
        return [
            'buttonType' => 'secondary',
            'buttonAction' => $this->url->getUrlByRouteName('rewrite_url_delete', ['id' => $urlId]),
            'label' => 'Delete URL'
        ];
    }
}