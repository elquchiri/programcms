<?php


namespace ElectroForums\ConfigBundle\Model;


class Config
{

    const SCOPE_TYPE_DEFAULT = 'default';

    private \Symfony\Component\DependencyInjection\ContainerInterface $container;
    private \ElectroForums\ConfigBundle\Repository\CoreConfigDataRepository $coreConfigDataRepository;

    public function __construct(
        \App\Kernel $kernel,
        \ElectroForums\ConfigBundle\Repository\CoreConfigDataRepository $coreConfigDataRepository
    )
    {
        $this->container = $kernel->getContainer();
        $this->coreConfigDataRepository = $coreConfigDataRepository;
    }

    public function getConfigValue($path, $scopeType = self::SCOPE_TYPE_DEFAULT, $scopeCode = 0) {
        // Find configuration in core_config_data
        $result = $this->coreConfigDataRepository->findOneBy([
            'path' => $path,
            'scope' => $scopeType,
            'scope_id' => $scopeCode
        ]);
        if($result) {
            return $result->getValue();
        }
        // If no configuration found on database, get configuration's defaultValues from packages
        $pathArray = explode('/', $path);
        return $this->container->getParameter('electroforums_system_config')['sections'][$pathArray[0]]['groups'][$pathArray[1]]['fields'][$pathArray[2]]['defaultValue'] ?? '';
    }

    public function setConfigValue($path, $value, $scopeType = self::SCOPE_TYPE_DEFAULT, $scopeCode = 0)
    {
        $config = $this->coreConfigDataRepository->findOneBy([
            'path' => $path,
            'scope' => $scopeType,
            'scope_id' => $scopeCode
        ]);

        // Check if config exists already, just set value to dispatch update
        if($config) {
            $config->setValue($value);
        }else{
            $config = new \ElectroForums\ConfigBundle\Entity\CoreConfigData();
            $config->setPath($path)
                ->setValue($value)
                ->setScope($scopeType)
                ->setScopeId($scopeCode);
        }

        // Persist & flush configuration
        $this->coreConfigDataRepository->save($config, true);
    }
}