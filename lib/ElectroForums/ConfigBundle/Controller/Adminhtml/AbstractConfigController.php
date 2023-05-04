<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ConfigBundle\Controller\Adminhtml;

use Symfony\Component\HttpFoundation\Response;

abstract class AbstractConfigController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    protected \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;
    protected \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer;
    protected \ElectroForums\ConfigBundle\Model\Config $config;
    protected \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator;
    protected \ElectroForums\RouterBundle\Service\Request $request;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar,
        \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer,
        \ElectroForums\ConfigBundle\Model\Config $config,
        \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
    )
    {
        parent::__construct($request);
        $this->toolbar = $toolbar;
        $this->configSerializer = $configSerializer;
        $this->config = $config;
        $this->urlGenerator = $urlGenerator;
        $this->request = $request;
    }

    protected function loadConfigurations(): Response
    {
        if($this->request->getParam('sectionId')) {
            $this->configSerializer->setSectionId($this->request->getParam('sectionId'));
        }

        $this->configSerializer->parseConfig();
        $tabs = $this->configSerializer->getConfigNavigation();
        $currentSectionGroups = $this->configSerializer->getCurrenSectionGroups();

        $this->toolbar->addButton(
            "Save Config",
            $this->urlGenerator->generate('config_systemconfig_save'),
            "save",
            "electroforums_config"
        );

        return $this->render('@ElectroForumsConfig/adminhtml/config.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'tabs' => $tabs,
            'currentSectionGroups' => $currentSectionGroups,
            'sectionId' => $this->configSerializer->getSectionId()
        ]);
    }
}