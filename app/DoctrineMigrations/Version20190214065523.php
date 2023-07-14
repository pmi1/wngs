<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190214065523 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E4A7843DC');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E4A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user CHANGE designer designer TINYINT(1) DEFAULT \'0\', CHANGE on_main on_main TINYINT(1) DEFAULT \'0\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E4A7843DC');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E4A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE user CHANGE designer designer TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE on_main on_main TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
