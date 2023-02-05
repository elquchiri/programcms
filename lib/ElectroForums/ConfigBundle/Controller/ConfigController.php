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

    public function __construct(
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar,
        \ElectroForums\ConfigBundle\Model\ConfigSerializer $configSerializer,
    )
    {
        $this->toolbar = $toolbar;
        $this->configSerializer = $configSerializer;
    }

    #[Route('/system_config/index', name: 'admin_configuration')]
    public function index(): Response
    {
        $this->configSerializer->parseConfig();
        $tabs = $this->configSerializer->getConfigNavigation();
        $currentSectionGroups = $this->configSerializer->getCurrenSectionGroups();

        $this->toolbar->addButton("Save Config", "", "primary");

        return $this->render('@ElectroForumsConfig/adminhtml/config.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'tabs' => $tabs,
            'currentSectionGroups' => $currentSectionGroups
        ]);
    }

    #[Route('/system_config/edit/section/{sectionId}', name: 'admin_configuration_edit')]
    public function section(Request $request): Response
    {
        $sectionId = $request->get('sectionId');
        $this->configSerializer->setSectionId($sectionId);
        $this->configSerializer->parseConfig();
        $tabs = $this->configSerializer->getConfigNavigation();
        $currentSectionGroups = $this->configSerializer->getCurrenSectionGroups();

        $this->toolbar->addButton("Save Config", "", "primary");

        return $this->render('@ElectroForumsConfig/adminhtml/config.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'tabs' => $tabs,
            'currentSectionGroups' => $currentSectionGroups
        ]);
    }
}