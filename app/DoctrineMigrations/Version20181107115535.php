<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181107115535 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, gallery INT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, cdate DATE DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, price INT DEFAULT NULL, discount SMALLINT DEFAULT NULL, INDEX IDX_1F1B251EA76ED395 (user_id), UNIQUE INDEX UNIQ_1F1B251E472B783A (gallery), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_attribute (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F6A0F90B126F525E (item_id), INDEX IDX_F6A0F90BB6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E472B783A FOREIGN KEY (gallery) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE item_attribute ADD CONSTRAINT FK_F6A0F90B126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_attribute ADD CONSTRAINT FK_F6A0F90BB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_attribute DROP FOREIGN KEY FK_F6A0F90B126F525E');
        $this->addSql('ALTER TABLE item_attribute DROP FOREIGN KEY FK_F6A0F90BB6E62EFA');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE item_attribute');
    }
}
