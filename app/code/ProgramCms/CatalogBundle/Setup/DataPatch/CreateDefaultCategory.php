<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Setup\DataPatch;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class CreateDefaultCategory
 * @package ProgramCms\CatalogBundle\Setup\DataPatch
 */
class CreateDefaultCategory extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function up(Schema $schema): void
    {
        // Perform your database updates here using the EntityManager or any other services
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        // Your update logic
    }

    public function down(Schema $schema): void
    {

    }
}