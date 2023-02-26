<?php


namespace ElectroForums\ConfigBundle\Controller\SystemConfig;


class SaveController extends \ElectroForums\ConfigBundle\Controller\AbstractConfigController
{

    public function __construct(\ElectroForums\RouterBundle\Service\Request $request, \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar, \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer, \ElectroForums\ConfigBundle\Model\Config $config, \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($request, $toolbar, $configSerializer, $config, $urlGenerator);
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

            return $this->redirectToRoute('electroforums_configbundle_edit', ['sectionId' => $sectionId]);
        }

        return $this->redirectToRoute('admin_configuration');
    }
}