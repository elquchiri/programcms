<?php


namespace ElectroForums\CoreBundle\Model\Utils;


use Symfony\Component\DependencyInjection\ContainerInterface;

class BundleManager
{
    protected ContainerInterface $container;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getAllEfBundles(): array
    {
        $efBundles = [];
        foreach ($this->container->getParameter('kernel.bundles') as $bundleName => $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            if ($reflectedBundle->hasMethod('isElectroForumsBundle') && $reflectedBundle->getMethod('isElectroForumsBundle')) {
                $bundleDirectory = dirname($reflectedBundle->getFileName());
                $efBundles[$bundleName] = [
                    'name' => $reflectedBundle->getShortName(),
                    'path' => $bundleDirectory
                ];
            }
        }

        return $efBundles;
    }

}