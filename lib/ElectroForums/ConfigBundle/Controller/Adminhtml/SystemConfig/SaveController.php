<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ConfigBundle\Controller\Adminhtml\SystemConfig;

/**
 * Class SaveController
 * @package ElectroForums\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class SaveController extends \ElectroForums\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{

    protected \ElectroForums\ConfigBundle\Model\Config $config;
    protected \ElectroForums\RouterBundle\Service\Url $url;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\RouterBundle\Service\Response $response,
        \ElectroForums\ConfigBundle\Model\Config $config,
        \ElectroForums\RouterBundle\Service\Url $url
    )
    {
        parent::__construct($request, $response);
        $this->config = $config;
        $this->url = $url;
    }

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
            $this->addFlash('success', 'Configuration Saved Succefully.');

            return $this->redirect($this->url->getUrlByRouteName('adminhtml_config_systemconfig_edit', ['sectionId' => $sectionId]));
        }

        return $this->redirectToRoute('adminhtml_config_systemconfig_index');
    }
}