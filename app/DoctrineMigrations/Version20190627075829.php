<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190627075829 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398126F525E');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988ABD09BB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988ABD09BB FOREIGN KEY (executor_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988ABD09BB');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398126F525E');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988ABD09BB FOREIGN KEY (executor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }
}
