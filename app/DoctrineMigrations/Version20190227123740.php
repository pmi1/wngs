<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190227123740 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE from_answer DROP FOREIGN KEY FK_57EC31F58C9F3610');
        $this->addSql('DROP INDEX IDX_57EC31F58C9F3610 ON from_answer');
        $this->addSql('ALTER TABLE from_answer ADD item_id INT DEFAULT NULL, ADD comment LONGTEXT DEFAULT NULL, DROP city, DROP call_time, DROP deleted_at, CHANGE file user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE from_answer ADD CONSTRAINT FK_57EC31F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE from_answer ADD CONSTRAINT FK_57EC31F5126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_57EC31F5A76ED395 ON from_answer (user_id)');
        $this->addSql('CREATE INDEX IDX_57EC31F5126F525E ON from_answer (item_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE from_answer DROP FOREIGN KEY FK_57EC31F5A76ED395');
        $this->addSql('ALTER TABLE from_answer DROP FOREIGN KEY FK_57EC31F5126F525E');
        $this->addSql('DROP INDEX IDX_57EC31F5A76ED395 ON from_answer');
        $this->addSql('DROP INDEX IDX_57EC31F5126F525E ON from_answer');
        $this->addSql('ALTER TABLE from_answer ADD file INT DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD call_time VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD deleted_at DATETIME DEFAULT NULL, DROP user_id, DROP item_id, DROP comment');
        $this->addSql('ALTER TABLE from_answer ADD CONSTRAINT FK_57EC31F58C9F3610 FOREIGN KEY (file) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_57EC31F58C9F3610 ON from_answer (file)');
    }
}
