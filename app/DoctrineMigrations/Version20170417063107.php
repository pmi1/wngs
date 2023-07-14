<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170417063107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `promo` CHANGE `country_id` `country_id` INT(11) NULL');
        $this->addSql('ALTER TABLE `promo` CHANGE `city_id` `city_id` INT(11) NULL');
        $this->addSql('ALTER TABLE `promo` CHANGE `med_direction_id` `med_direction_id` INT(11) NULL');
        $this->addSql('ALTER TABLE `promo` CHANGE `disease_id` `disease_id` INT(11) NULL');
        $this->addSql('ALTER TABLE `promo` CHANGE `clinic_id` `clinic_id` INT(11) NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
