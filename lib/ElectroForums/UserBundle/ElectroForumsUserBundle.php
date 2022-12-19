<?php


namespace ElectroForums\UserBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class ElectroForumsUserBundle extends Bundle
{
    public const VERSION = '1.0.0';

//    public function build(ContainerBuilder $container)
//    {
//        parent::build($container);
//        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
//
//        if (class_exists($ormCompilerClass)) {
//            $namespaces = array('ElectroForums\CustomerBundle\Model\Entity');
//            $directories = array(realpath(__DIR__.'/Model/Entity'));
//            $managerParameters = array();
//            $enabledParameter = false;
//            $aliasMap = array('CustomerBundle' => 'ElectroForums\CustomerBundle\Entity');
//            $container->addCompilerPass(
//                DoctrineOrmMappingsPass::createAnnotationMappingDriver(
//                    $namespaces,
//                    $directories,
//                    $managerParameters,
//                    $enabledParameter,
//                    $aliasMap
//                )
//            );
//        }
//    }
}