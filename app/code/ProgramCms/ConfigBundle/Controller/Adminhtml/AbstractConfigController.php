<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml;

use ProgramCms\ConfigBundle\Model\Config;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AbstractConfigController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml
 */
abstract class AbstractConfigController extends \ProgramCms\CoreBundle\Controller\Controller
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
     * @var Config
     */
    protected Config $config;
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * AbstractConfigController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param Config $config
     * @param Url $url
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        Config $config,
        Url $url,
        TranslatorInterface $translator
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->translator = $context->getTranslator();
        $this->config = $config;
        $this->url = $url;
        $this->translator = $translator;
    }

    /**
     * @return object|null
     */
    protected function loadConfigurations()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->getMethod() == 'POST') {
            return $this->save();
        }

        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->translator->trans("Configuration")
        );
        return $pageResult;
    }

    /**
     * Save App Config
     * @return RedirectResponse
     */
    protected function save(): RedirectResponse
    {
        $request = $this->getRequest()->getCurrentRequest();
        $formData = $request->request->all();
        $sectionId = $formData['section_id'] ?? "";
        foreach ($formData as $name => $value) {
            if ($name != 'section_id') {
                $this->config->setConfigValue(
                    $sectionId . '/' . $name,
                    $value
                );
            }
        }
        // Flash success message
        $this->addFlash('success',
            $this->translator->trans('Configuration Successfully Saved.')
        );

        return $this->redirect($this->url->getUrlByRouteName('config_systemconfig_edit', ['sectionId' => $sectionId]));
    }
}