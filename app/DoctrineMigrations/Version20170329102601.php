<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170329102601 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE IF NOT EXISTS `clinic_med_direction` (
              `clinic_id` int(11) NOT NULL,
              `med_direction_id` int(11) NOT NULL,
              `text_type` longtext COLLATE utf8_unicode_ci,
              `text_raw` longtext COLLATE utf8_unicode_ci,
              `text_formatted` longtext COLLATE utf8_unicode_ci
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        ');
        $this->addSql('ALTER TABLE `clinic_med_direction` ADD PRIMARY KEY (`clinic_id`,`med_direction_id`)');
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
