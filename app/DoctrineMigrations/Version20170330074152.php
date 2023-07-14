<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170330074152 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE IF NOT EXISTS `med_doctor` (
        `doctor_id` int(11) NOT NULL,
        `med_direction_id` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        $this->addSql('ALTER TABLE `med_doctor`
        ADD PRIMARY KEY (`doctor_id`,`med_direction_id`),
        ADD KEY `IDX_FE59468B87F4FB17` (`doctor_id`),
        ADD KEY `IDX_FE59468BC224826D` (`med_direction_id`)');
        $this->addSql('ALTER TABLE `med_doctor`
        ADD CONSTRAINT `FK_FE59468BC224826D` FOREIGN KEY (`med_direction_id`) REFERENCES `med_direction` (`med_direction_id`),
        ADD CONSTRAINT `FK_FE59468B87F4FB17` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`)');
        
        $this->addSql('CREATE TABLE IF NOT EXISTS `med_cost_example` (
        `cost_example_id` int(11) NOT NULL,
        `med_direction_id` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        $this->addSql('ALTER TABLE `med_cost_example`
        ADD PRIMARY KEY (`cost_example_id`,`med_direction_id`),
        ADD KEY `IDX_45D5485ADD603BE6` (`cost_example_id`),
        ADD KEY `IDX_45D5485AC224826D` (`med_direction_id`)');
        $this->addSql('ALTER TABLE `med_cost_example`
        ADD CONSTRAINT `FK_45D5485AC224826D` FOREIGN KEY (`med_direction_id`) REFERENCES `med_direction` (`med_direction_id`),
        ADD CONSTRAINT `FK_45D5485ADD603BE6` FOREIGN KEY (`cost_example_id`) REFERENCES `cost_example` (`cost_example_id`)');
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
