<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;

/**
 * Save Application's Configuration
 * Class SaveController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class SaveController extends \ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{
    /**
     * @var \ProgramCms\ConfigBundle\Model\Config
     */
    protected \ProgramCms\ConfigBundle\Model\Config $config;
    /**
     * @var \ProgramCms\RouterBundle\Service\Url
     */
    protected \ProgramCms\RouterBundle\Service\Url $url;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        \ProgramCms\ConfigBundle\Model\Config $config,
        \ProgramCms\RouterBundle\Service\Url $url,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($request, $response, $objectManager);
        $this->config = $config;
        $this->url = $url;
    }

    /**
     * Save App Config
     * @return mixed|\Symfony\Component\HttpFoundation\RedirectResponse
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
            $this->addFlash('success', 'Configuration Saved Succefully.');

            return $this->redirect($this->url->getUrlByRouteName('adminhtml_config_systemconfig_edit', ['sectionId' => $sectionId]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Configuration Data, please try again.');
        return $this->redirectToRoute('adminhtml_config_systemconfig_index');
    }
}