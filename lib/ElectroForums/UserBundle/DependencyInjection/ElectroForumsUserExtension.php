<?php


namespace ElectroForums\UserBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ElectroForumsUserExtension extends Extension implements PrependExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader =new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('electro_forums_user.my_var_string', $config['my_var_string']);
        $container->setParameter('electro_forums_user.my_array', $config['my_array']);
        $container->setParameter('electro_forums_user.my_integer', $config['my_integer']);
        $container->setParameter('electro_forums_user.my_var_string_option', $config['my_var_string_option']);
    }

    public function prepend(ContainerBuilder $container)
    {
        // get all bundles
        $bundles = $container->getParameter('kernel.bundles');
        // determine if AcmeGoodbyeBundle is registered
        if (!isset($bundles['AcmeGoodbyeBundle'])) {
            // disable AcmeGoodbyeBundle in bundles
            $config = ['use_acme_goodbye' => false];
            foreach ($container->getExtensions() as $name => $extension) {
                match ($name) {
                    // set use_acme_goodbye to false in the config of
                    // acme_something and acme_other
                    //
                    // note that if the user manually configured
                    // use_acme_goodbye to true in config/services.yaml
                    // then the setting would in the end be true and not false
                    'acme_something', 'acme_other' => $container->prependExtensionConfig($name, $config),
                    default => null
                };
            }
        }

        // get the configuration of AcmeHelloExtension (it's a list of configuration)
        $configs = $container->getExtensionConfig($this->getAlias());

        // iterate in reverse to preserve the original order after prepending the config
        foreach (array_reverse($configs) as $config) {
            // check if entity_manager_name is set in the "acme_hello" configuration
            if (isset($config['entity_manager_name'])) {
                // prepend the acme_something settings with the entity_manager_name
                $container->prependExtensionConfig('acme_something', [
                    'entity_manager_name' => $config['entity_manager_name'],
                ]);
            }
        }
//        $twigConfig = [];
//        $twigConfig['paths'][__DIR__.'/../Resources/views'] = "ElectroForumsCustomer";
//        $twigConfig['paths'][__DIR__.'/../Resources/public'] = "ElectroForumsCustomer.public";
//        $container->prependExtensionConfig('twig', $twigConfig);
    }

    public function getAlias(): string
    {
        return parent::getAlias();
    }
}