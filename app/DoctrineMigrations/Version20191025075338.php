<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191025075338 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT \'1\' NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_794381C68D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE review');
    }
}
