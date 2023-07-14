<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181204115840 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE brand brand VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE facebook facebook VARCHAR(255) DEFAULT NULL, CHANGE instagram instagram VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL, CHANGE behance behance VARCHAR(255) DEFAULT NULL, CHANGE vk vk VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE phone phone VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE brand brand VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE facebook facebook VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE instagram instagram VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE twitter twitter VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE behance behance VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE vk vk VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
