<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CommentBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ElectroForumsCommentExtension extends Extension
{

    public function getAlias(): string
    {
        return parent::getAlias();
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}