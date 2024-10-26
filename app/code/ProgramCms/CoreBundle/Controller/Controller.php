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
use ProgramCms\CoreBundle\View\DesignLoader;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;
use HttpResponseException;
use ReflectionException;

/**
 * Class Controller
 * @package ProgramCms\CoreBundle\Controller
 */
abstract class Controller extends AbstractController
{
    /**
     * @var State
     */
    protected State $_state;

    /**
     * @var AreaList
     */
    protected AreaList $_areaList;

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
     * Controller constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
    )
    {
        parent::__construct($context);
        $this->_areaList = $context->getAreaList();
        $this->_state = $context->getState();
        $this->localeSwitcher = $context->getLocaleSwitcher();
        $this->security = $context->getSecurity();
        $this->translator = $context->getTranslator();
        $this->config = $context->getConfig();
        $this->designLoader = $context->getDesignLoader();
        $this->url = $context->getUrl();
    }

    /**
     * Dispatch Request
     * @return mixed
     * @throws HttpResponseException|ReflectionException
     */
    public function dispatch(): mixed
    {
        $areaCode = $this->_areaList->getCodeByFrontName($this->getRequest()->getFrontName());
        $this->_state->setAreaCode($areaCode);

        // Load Design Part
        $this->designLoader->load();

        // Set website view locale
        $locale = $this->config->getValue('general/locale_options/locale', 'website_view');
        $this->localeSwitcher->setLocale($locale);

        $result = $this->execute();
        if($result instanceof Page) {
            try {
                return $result->render();
            } catch (\Exception $e) {
                dd($e->getMessage());
                // TODO: Log errors instead of printing
                var_dump($e->getTraceAsString());
            }
        }
        else if($result instanceof Response) {
            return $result;
        }

        throw new HttpResponseException("Unexpected Result instance.");
    }

    /**
     * Helper for translate inside Controller classes
     * @param string $message
     * @param mixed ...$params
     * @return string
     */
    public function trans(string $message, ...$params): string
    {
        return isset($params) && !empty($params)
            ? sprintf($this->translator->trans($message), ...$params)
            : $this->translator->trans($message);
    }

    /**
     * Helper for Current User
     * @return Security
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }
}