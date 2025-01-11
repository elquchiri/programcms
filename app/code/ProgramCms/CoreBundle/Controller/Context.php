<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\App\AreaList;
use ProgramCms\CoreBundle\App\State;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\Response;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use ProgramCms\CoreBundle\View\DesignLoader;
use Twig\Environment;

/**
 * Class Context
 * @package ProgramCms\CoreBundle\Controller
 */
class Context implements ContextInterface
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var AreaList
     */
    protected AreaList $areaList;

    /**
     * @var State
     */
    protected State $state;

    /**
     * @var LocaleSwitcher
     */
    protected LocaleSwitcher $localeSwitcher;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var DesignLoader
     */
    protected DesignLoader $designLoader;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * @var Environment
     */
    protected Environment $environment;

    /**
     * Context constructor.
     * @param Request $request
     * @param Response $response
     * @param AreaList $areaList
     * @param State $state
     * @param LocaleSwitcher $localeSwitcher
     * @param Security $security
     * @param TranslatorInterface $translator
     * @param Config $config
     * @param DesignLoader $designLoader
     * @param Url $url
     * @param WebsiteManagerInterface $websiteManager
     * @param Environment $environment
     */
    public function __construct(
        Request $request,
        Response $response,
        AreaList $areaList,
        State $state,
        LocaleSwitcher $localeSwitcher,
        Security $security,
        TranslatorInterface $translator,
        Config $config,
        DesignLoader $designLoader,
        Url $url,
        WebsiteManagerInterface $websiteManager,
        Environment $environment
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->areaList = $areaList;
        $this->state = $state;
        $this->localeSwitcher = $localeSwitcher;
        $this->security = $security;
        $this->translator = $translator;
        $this->config = $config;
        $this->designLoader = $designLoader;
        $this->url = $url;
        $this->websiteManager = $websiteManager;
        $this->environment = $environment;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return AreaList
     */
    public function getAreaList(): AreaList
    {
        return $this->areaList;
    }

    /**
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @return LocaleSwitcher
     */
    public function getLocaleSwitcher(): LocaleSwitcher
    {
        return $this->localeSwitcher;
    }

    /**
     * @return Security
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return DesignLoader
     */
    public function getDesignLoader(): DesignLoader
    {
        return $this->designLoader;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return WebsiteManagerInterface
     */
    public function getWebsiteManager(): WebsiteManagerInterface
    {
        return $this->websiteManager;
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }
}