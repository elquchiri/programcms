<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Block;

/**
 * Class Configuration
 * @package ProgramCms\ConfigBundle\Block
 */
class ConfigTabs extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var \ProgramCms\ConfigBundle\Model\ConfigSerializer
     */
    protected \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer;
    /**
     * @var \ProgramCms\RouterBundle\Service\Request
     */
    protected \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->request = $context->getRequest();
        // Init Config Serializer
        $this->initConfigSerializer();
    }

    /**
     * @throws \ReflectionException
     */
    private function initConfigSerializer()
    {
        if($this->request->getParam('sectionId')) {
            $this->configSerializer->setSectionId($this->request->getParam('sectionId'));
        }

        $this->configSerializer->parseConfig();
    }

    /**
     * @return mixed
     */
    public function getTabs()
    {
        return $this->configSerializer->getConfigNavigation();
    }
}