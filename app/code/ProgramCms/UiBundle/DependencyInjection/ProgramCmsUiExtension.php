<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\DependencyInjection;

use Exception;
use InvalidArgumentException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class ProgramCmsUiExtension
 * @package ProgramCms\UiBundle\DependencyInjection
 */
class ProgramCmsUiExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }

    /**
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $yamlParser = new \Symfony\Component\Yaml\Parser();
        $doctrineConfigFile = __DIR__.'/../Resources/config/doctrine.yaml';

        try {
            $doctrineConfig = $yamlParser->parse(
                file_get_contents($doctrineConfigFile)
            );
        } catch (ParseException $e) {
            throw new InvalidArgumentException(sprintf('The file "%s" does not contain valid YAML.', $doctrineConfigFile), 0, $e);
        }

        $container->prependExtensionConfig('doctrine', $doctrineConfig['doctrine']);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return parent::getAlias();
    }
}