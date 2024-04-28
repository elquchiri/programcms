<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml;

use HttpResponseException;
use ProgramCms\ConfigBundle\Model\ConfigSerializer;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\RouterBundle\Service\Url;
use Symfony\Contracts\Translation\TranslatorInterface;
use ReflectionException;

/**
 * Class AbstractConfigController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml
 */
abstract class AbstractConfigController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var ConfigSerializer
     */
    protected ConfigSerializer $configSerializer;

    /**
     * AbstractConfigController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param ConfigSerializer $configSerializer
     * @param Url $url
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        ConfigSerializer $configSerializer,
        Url $url,
        TranslatorInterface $translator
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->translator = $context->getTranslator();
        $this->configSerializer = $configSerializer;
    }

    /**
     * @return mixed
     * @throws HttpResponseException|ReflectionException
     */
    public function dispatch(): mixed
    {
        if(!$this->getRequest()->getParam('section')) {
            $this->getRequest()->setParam('section', $this->configSerializer->getFirstSection()->getId());
        }
        return parent::dispatch();
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function loadConfigurations()
    {
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->translator->trans("Configuration")
        );
        return $pageResult;
    }
}