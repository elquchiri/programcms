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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Translation\LocaleSwitcher;

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
    }

    /**
     * Dispatch Request
     * @return mixed
     * @throws HttpResponseException
     */
    public function dispatch(): mixed
    {
        $user = $this->security->getUser();
        if($user) {
            $this->localeSwitcher->setLocale($user->getInterfaceLocale());
        }
        $areaCode = $this->_areaList->getCodeByFrontName($this->getRequest()->getFrontName());
        $this->_state->setAreaCode($areaCode);
        $result = $this->execute();
        if($result instanceof \ProgramCms\CoreBundle\View\Result\Page) {
            return $this->execute()->render();
        }
        else if($result instanceof \Symfony\Component\HttpFoundation\RedirectResponse) {
            return $result;
        }

        throw new HttpResponseException("Unexpected Result instance.");
    }
}