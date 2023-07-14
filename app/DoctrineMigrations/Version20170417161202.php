<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170417161202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE  `opinion` DROP FOREIGN KEY  `FK_AB02B027BF396750`');
        $this->addSql('ALTER TABLE  `opinion` DROP  `id`');
        $this->addSql("ALTER TABLE  `opinion` ADD COLUMN country_id INT(11) NULL");
        $this->addSql("ALTER TABLE  `opinion` ADD CONSTRAINT `FK_AB02B027F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
