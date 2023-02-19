<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219043041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE core_config_data (config_id INT AUTO_INCREMENT NOT NULL, scope VARCHAR(255) NOT NULL, scope_id INT NOT NULL, path VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(config_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eav_entity_attribute ADD attribute_set_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE core_config_data');
        $this->addSql('ALTER TABLE eav_entity_attribute DROP attribute_set_id');
    }
}
