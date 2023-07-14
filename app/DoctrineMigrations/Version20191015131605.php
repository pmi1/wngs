<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191015131605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD country VARCHAR(255) DEFAULT NULL, ADD zip VARCHAR(255) DEFAULT NULL, ADD street VARCHAR(255) DEFAULT NULL, ADD building VARCHAR(255) DEFAULT NULL, ADD apartment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8D9F6D38');
        $this->addSql('ALTER TABLE message RENAME INDEX idx_790009e38d9f6d38 TO IDX_B6BD307F8D9F6D38');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message RENAME INDEX idx_b6bd307f8d9f6d38 TO IDX_790009E38D9F6D38');
        $this->addSql('ALTER TABLE `order` DROP country, DROP zip, DROP street, DROP building, DROP apartment');
    }
}
