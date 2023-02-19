<?php


namespace ElectroForums\ConfigBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{

    private \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;
    private \Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface $parameterBag;
    private \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer;
    private Request $request;
    private \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator;
    private \ElectroForums\ConfigBundle\Model\Config $config;

    public function __construct(
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar,
        \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer,
        \ElectroForums\ConfigBundle\Model\Config $config,
        \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
    )
    {
        $this->toolbar = $toolbar;
        $this->configSerializer = $configSerializer;
        $this->urlGenerator = $urlGenerator;
        $this->config = $config;
    }

    protected function loadConfigurations(Request $request): Response
    {
        try {
            $sectionId = $request->get('sectionId') ?? $this->configSerializer->getSectionId();
            $this->configSerializer->setSectionId($sectionId);
            $this->configSerializer->parseConfig();

            $tabs = $this->configSerializer->getConfigNavigation();
            $currentSectionGroups = $this->configSerializer->getCurrenSectionGroups();

            $this->toolbar->addButton(
                "Save Config",
                $this->urlGenerator->generate('admin_configuration_save'),
                "save",
                "electroforums_config"
            );

            return $this->render('@ElectroForumsConfig/adminhtml/config.html.twig', [
                'buttons' => $this->toolbar->getButtons(),
                'tabs' => $tabs,
                'currentSectionGroups' => $currentSectionGroups,
                'sectionId' => $this->configSerializer->getSectionId()
            ]);
        }catch(\Exception $e) {

        }
    }

    #[Route('/system_config/index', name: 'admin_configuration')]
    public function index(Request $request): Response
    {
        return self::loadConfigurations($request);
    }

    #[Route('/system_config/edit/section/{sectionId}', name: 'admin_configuration_edit')]
    public function section(Request $request): Response
    {
        return self::loadConfigurations($request);
    }

    #[Route('/system_config/save', name: 'admin_configuration_save')]
    public function saveSection(Request $request): Response
    {
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

            return $this->redirectToRoute('admin_configuration_edit', ['sectionId' => $sectionId]);
        }

        return $this->redirectToRoute('admin_configuration');
    }
}