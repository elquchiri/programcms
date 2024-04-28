<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

use HttpResponseException;
use ProgramCms\CoreBundle\App\AreaList;
use ProgramCms\CoreBundle\App\State;
use ReflectionException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;
use ProgramCms\CoreBundle\View\DesignLoader;

/**
 * Class AdminController
 * @package ProgramCms\CoreBundle\Controller
 */
abstract class AdminController extends AbstractController
{
    /**
     * @var State
     */
    protected State $state;

    /**
     * @var AreaList
     */
    protected AreaList $areaList;

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
     * @var DesignLoader
     */
    protected DesignLoader $designLoader;

    /**
     * Controller constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
    )
    {
        parent::__construct($context);
        $this->areaList = $context->getAreaList();
        $this->state = $context->getState();
        $this->localeSwitcher = $context->getLocaleSwitcher();
        $this->security = $context->getSecurity();
        $this->translator = $context->getTranslator();
        $this->designLoader = $context->getDesignLoader();
    }

    /**
     * Dispatch Request
     * @return mixed
     * @throws HttpResponseException
     * @throws ReflectionException
     */
    public function dispatch(): mixed
    {
        // Set Current AreaCode
        $areaCode = $this->areaList->getCodeByFrontName($this->getRequest()->getFrontName());
        $this->state->setAreaCode($areaCode);

        // Load Design Part
        $this->designLoader->load();

        $locale = $this->localeSwitcher->getLocale();
        if($user = $this->security->getUser()) {
            $locale = $user->getInterfaceLocale();
        }

        // Set defined user locale
        $this->localeSwitcher->setLocale($locale);

        // Run Controller's Action
        $result = $this->execute();
        if($result instanceof \ProgramCms\CoreBundle\View\Result\Page) {
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
     * Helper to get user
     * @return Security
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }
}