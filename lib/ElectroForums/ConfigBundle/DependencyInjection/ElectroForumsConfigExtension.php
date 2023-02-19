<?php
/**
 * ElectroForums Community Edition
 *
 * Dashboard Sidebar Manager
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 * Created 04/12/2022
 */

namespace ElectroForums\ConfigBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class ElectroForumsConfigExtension extends Extension implements PrependExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function getAlias(): string
    {
        return parent::getAlias();
    }

    public function prepend(ContainerBuilder $container)
    {
        $combinedConfig = [];
        // Get all bundles
        $bundles = array_keys($container->getParameter('kernel.bundles'));
        foreach ($bundles as $bundleName) {
            $containerParamBundle = str_replace('Bundle', '', $bundleName);
            $containerParamBundle = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $containerParamBundle));
            // Get bundle's ElectroForums Configuration Section
            $configs = $container->getExtensionConfig($containerParamBundle)[0]['system_config'] ?? [];

            if(isset($configs['sections'])) {
                foreach($configs['sections'] as $sectionId => $section) {
                    // Merge groups & fields
                    if(isset($section['groups'])) {
                        foreach($section['groups'] as $groupId => $group) {
                            if(isset($group['fields'])) {
                                foreach ($group['fields'] as $fieldId => $field) {
                                    if(isset($field['defaultValue'])) {
                                        $combinedConfig['sections'][$sectionId]['groups'][$groupId]['fields'][$fieldId] = [
                                            'defaultValue' => $field['defaultValue']
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $container->setParameter('electroforums_system_config', $combinedConfig);
    }
}