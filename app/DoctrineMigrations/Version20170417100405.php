<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170417100405 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country ADD image INT DEFAULT NULL, ADD country_name_rd VARCHAR(255) NOT NULL, ADD country_name_dt VARCHAR(255) NOT NULL, ADD country_name_tv VARCHAR(255) NOT NULL, ADD country_name_pr VARCHAR(255) NOT NULL, ADD price_segment INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_5373C966C53D045F ON country (image)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C966C53D045F');
        $this->addSql('DROP INDEX IDX_5373C966C53D045F ON country');
        $this->addSql('ALTER TABLE country DROP image, DROP country_name_rd, DROP country_name_dt, DROP country_name_tv, DROP country_name_pr, DROP price_segment');
    }
}
