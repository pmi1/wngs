<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620175451 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("UPDATE `cmf_script` SET `url` = '/about' WHERE `cmf_script`.`id` = 77");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/countries' WHERE `cmf_script`.`id` = 79");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/about' WHERE `cmf_script`.`id` = 81");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/countries' WHERE `cmf_script`.`id` = 83");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/countries' WHERE `cmf_script`.`id` = 87");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/specialities' WHERE `cmf_script`.`id` = 88");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/feedbacks' WHERE `cmf_script`.`id` = 90");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/search' WHERE `cmf_script`.`id` = 92");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/specialities' WHERE `cmf_script`.`id` = 93");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/information' WHERE `cmf_script`.`id` = 94");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/feedbacks' WHERE `cmf_script`.`id` = 95");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/specialities' WHERE `cmf_script`.`id` = 97");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/contacts' WHERE `cmf_script`.`id` = 96");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/information' WHERE `cmf_script`.`id` = 98");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/feedbacks' WHERE `cmf_script`.`id` = 99");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/contacts' WHERE `cmf_script`.`id` = 100");
        $this->addSql("UPDATE `cmf_script` SET `url` = '/compare' WHERE `cmf_script`.`id` = 112");
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
