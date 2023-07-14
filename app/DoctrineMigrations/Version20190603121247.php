<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190603121247 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item ADD delivery LONGTEXT DEFAULT NULL, ADD payment LONGTEXT DEFAULT NULL, ADD `condition` LONGTEXT DEFAULT NULL, DROP delivery_raw, DROP delivery_formatted, DROP delivery_type, DROP payment_raw, DROP payment_formatted, DROP payment_type, DROP condition_raw, DROP condition_formatted, DROP condition_type');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item ADD delivery_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD delivery_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD delivery_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD payment_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD payment_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD payment_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD condition_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD condition_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD condition_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, DROP delivery, DROP payment, DROP `condition`');
    }
}
