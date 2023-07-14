<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181101090743 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, parent_id INT NOT NULL, depth INT NOT NULL, status TINYINT(1) DEFAULT \'0\', real_status TINYINT(1) DEFAULT \'0\', catname VARCHAR(255) DEFAULT NULL, realcatname VARCHAR(255) DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT DEFAULT NULL, left_margin INT NOT NULL, right_margin INT NOT NULL, lastnode TINYINT(1) DEFAULT \'0\', deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE catalogue');
    }
}
