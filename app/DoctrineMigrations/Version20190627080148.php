<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190627080148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE from_answer DROP FOREIGN KEY FK_57EC31F5126F525E');
        $this->addSql('ALTER TABLE from_answer ADD CONSTRAINT FK_57EC31F5126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE from_answer DROP FOREIGN KEY FK_57EC31F5126F525E');
        $this->addSql('ALTER TABLE from_answer ADD CONSTRAINT FK_57EC31F5126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }
}
