<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;

use ProgramCms\ConfigBundle\Model\Config;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Save Application's Configuration
 * Class SaveController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class SaveController extends \ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{
    /**
     * @var Config
     */
    protected Config $config;
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Config $config
     * @param Url $url
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        Config $config,
        Url $url,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context, $objectManager);
        $this->config = $config;
        $this->url = $url;
    }

    /**
     * Save App Config
     * @return RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            $sectionId = $formData['section_id'] ?? "";
            foreach($formData as $name => $value) {
                if($name != 'section_id') {
                    $this->config->setConfigValue(
                        $sectionId . '/' . $name,
                        $value
                    );
                }
            }
            // Flash success message
            $this->addFlash('success', 'Configuration Successfully Saved.');

            return $this->redirect($this->url->getUrlByRouteName('config_systemconfig_edit', ['sectionId' => $sectionId]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Configuration Data, please try again.');
        return $this->redirectToRoute('adminhtml_config_systemconfig_index');
    }
}