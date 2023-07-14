<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170815084531 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE med_direction ADD icon_inverse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8756F2F0 FOREIGN KEY (icon_inverse) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_860B1AD8756F2F0 ON med_direction (icon_inverse)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE med_direction DROP FOREIGN KEY FK_860B1AD8756F2F0');
        $this->addSql('DROP INDEX IDX_860B1AD8756F2F0 ON med_direction');
        $this->addSql('ALTER TABLE med_direction DROP icon_inverse');
    }
}
