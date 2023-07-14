<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613083113 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE from_answer ADD file INT DEFAULT NULL, DROP answer_file');
        $this->addSql('ALTER TABLE from_answer ADD CONSTRAINT FK_57EC31F58C9F3610 FOREIGN KEY (file) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_57EC31F58C9F3610 ON from_answer (file)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE from_answer DROP FOREIGN KEY FK_57EC31F58C9F3610');
        $this->addSql('DROP INDEX IDX_57EC31F58C9F3610 ON from_answer');
        $this->addSql('ALTER TABLE from_answer ADD answer_file VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP file');
    }
}
