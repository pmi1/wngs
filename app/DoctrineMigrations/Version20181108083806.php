<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181108083806 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE selection (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_96A50CD7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_selection (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, selection_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_9A7F1A27126F525E (item_id), INDEX IDX_9A7F1A27E48EFE78 (selection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE selection ADD CONSTRAINT FK_96A50CD7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE item_selection ADD CONSTRAINT FK_9A7F1A27126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_selection ADD CONSTRAINT FK_9A7F1A27E48EFE78 FOREIGN KEY (selection_id) REFERENCES selection (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_selection DROP FOREIGN KEY FK_9A7F1A27E48EFE78');
        $this->addSql('DROP TABLE selection');
        $this->addSql('DROP TABLE item_selection');
    }
}
