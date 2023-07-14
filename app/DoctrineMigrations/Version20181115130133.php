<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181115130133 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD phone VARCHAR(255) NOT NULL, ADD text_type LONGTEXT DEFAULT NULL, ADD text_raw LONGTEXT DEFAULT NULL, ADD text_formatted LONGTEXT DEFAULT NULL, ADD delivery_type LONGTEXT DEFAULT NULL, ADD delivery_raw LONGTEXT DEFAULT NULL, ADD delivery_formatted LONGTEXT DEFAULT NULL, ADD payment_type LONGTEXT DEFAULT NULL, ADD payment_raw LONGTEXT DEFAULT NULL, ADD payment_formatted LONGTEXT DEFAULT NULL, ADD facebook VARCHAR(255) NOT NULL, ADD instagram VARCHAR(255) NOT NULL, ADD twitter VARCHAR(255) NOT NULL, ADD behance VARCHAR(255) NOT NULL, ADD vk VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP phone, DROP text_type, DROP text_raw, DROP text_formatted, DROP delivery_type, DROP delivery_raw, DROP delivery_formatted, DROP payment_type, DROP payment_raw, DROP payment_formatted, DROP facebook, DROP instagram, DROP twitter, DROP behance, DROP vk');
    }
}
