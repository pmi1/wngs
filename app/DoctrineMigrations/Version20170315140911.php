<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170315140911 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("ALTER TABLE user ADD COLUMN `plain_password` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' AFTER `status`");
        $this->addSql("UPDATE user SET `password` = '\$2y\$12\$wek8Osd2txERT4.zQ27BpOiJjIDogNp41N.xCCzrlG66gE6h70E06' WHERE user_id = 3");
        $this->addSql("UPDATE cmf_script SET `name` = 'Роли' WHERE id = 32");
        $this->addSql("UPDATE cmf_script SET `name` = 'Группы ролей' WHERE id = 33");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `user` DROP COLUMN `plain_password`');
        
    }
}
