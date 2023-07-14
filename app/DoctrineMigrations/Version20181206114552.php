<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181206114552 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page ADD image INT DEFAULT NULL, ADD link VARCHAR(255) DEFAULT NULL, DROP meta_title, DROP meta_description, DROP meta_keywords, DROP h1, DROP preview_raw, DROP preview_type, DROP preview_formatted');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_140AB620C53D045F ON page (image)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620C53D045F');
        $this->addSql('DROP INDEX IDX_140AB620C53D045F ON page');
        $this->addSql('ALTER TABLE page ADD meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD h1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, DROP image, CHANGE link meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
