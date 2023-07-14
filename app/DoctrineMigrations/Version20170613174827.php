<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613174827 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fake_disease_direction (disease_id INT NOT NULL, med_direction_id INT NOT NULL, INDEX IDX_843D9554D8355341 (disease_id), INDEX IDX_843D9554C224826D (med_direction_id), PRIMARY KEY(disease_id, med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fake_disease_direction ADD CONSTRAINT FK_843D9554D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE fake_disease_direction ADD CONSTRAINT FK_843D9554C224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fake_disease_direction');
    }
}
