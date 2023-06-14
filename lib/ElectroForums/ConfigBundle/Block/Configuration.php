<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ConfigBundle\Block;

use Twig\Environment;

/**
 * Class Configuration
 * @package ElectroForums\ConfigBundle\Block
 */
class Configuration extends \ElectroForums\CoreBundle\View\Element\Template
{

    protected \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer;
    protected \ElectroForums\RouterBundle\Service\Request $request;

    public function __construct(
        Environment $environment,
        \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer,
        \ElectroForums\RouterBundle\Service\Request $request
    )
    {
        parent::__construct($environment);
        $this->configSerializer = $configSerializer;
        $this->request = $request;

        $this->initConfigSerializer();
    }

    private function initConfigSerializer()
    {
        if($this->request->getParam('sectionId')) {
            $this->configSerializer->setSectionId($this->request->getParam('sectionId'));
        }

        $this->configSerializer->parseConfig();
    }

    public function getTabs()
    {
        return $this->configSerializer->getConfigNavigation();
    }

    public function getCurrentSectionGroups()
    {
        return $this->configSerializer->getCurrenSectionGroups();
    }

    public function getSectionId()
    {
        return $this->configSerializer->getSectionId();
    }
}