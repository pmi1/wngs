<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170704115556 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country_med_direction CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_main CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE med_direction CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE manipulation CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE country_disease CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE certificate CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cmf_script CHANGE status status TINYINT(1) DEFAULT \'0\', CHANGE real_status real_status TINYINT(1) DEFAULT \'0\', CHANGE ordering ordering INT DEFAULT NULL, CHANGE lastnode lastnode TINYINT(1) DEFAULT \'0\', CHANGE modelname modelname VARCHAR(255) DEFAULT \'\', CHANGE is_group_node is_group_node TINYINT(1) DEFAULT \'0\', CHANGE is_new_win is_new_win TINYINT(1) DEFAULT \'0\', CHANGE is_exclude_path is_exclude_path TINYINT(1) DEFAULT \'0\', CHANGE is_search is_search TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE promo CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opinion CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE doctor_specialisation CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cost_example CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_attr_group CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lang_support CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE last_request CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE disease CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE city CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE role CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE curator CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE service_clinic_type CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_disease CHANGE enabled enabled TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE favourite favourite TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE clinic_param CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_attr CHANGE multi_var multi_var TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cmf_configure CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price_segment CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic CHANGE discount discount SMALLINT DEFAULT NULL, CHANGE ordering ordering INT DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE clinic_med_direction CHANGE favourite favourite TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE doctor_degree CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ordering ordering INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE certificate CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE city CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE clinic CHANGE discount discount INT DEFAULT NULL, CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE clinic_attr CHANGE multi_var multi_var TINYINT(1) NOT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE clinic_attr_group CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE clinic_disease CHANGE enabled enabled TINYINT(1) NOT NULL, CHANGE favourite favourite TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE clinic_med_direction CHANGE favourite favourite TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_param CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE cmf_configure CHANGE ordering ordering INT DEFAULT 0');
        $this->addSql('ALTER TABLE cmf_script CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE real_status real_status TINYINT(1) DEFAULT NULL, CHANGE ordering ordering INT NOT NULL, CHANGE lastnode lastnode TINYINT(1) DEFAULT NULL, CHANGE modelname modelname VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE is_group_node is_group_node TINYINT(1) DEFAULT NULL, CHANGE is_new_win is_new_win TINYINT(1) DEFAULT NULL, CHANGE is_exclude_path is_exclude_path TINYINT(1) DEFAULT NULL, CHANGE is_search is_search TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE cost_example CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE country CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE country_disease CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE country_med_direction CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE curator CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE disease CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE doctor CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE doctor_degree CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE doctor_specialisation CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE lang_support CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE last_request CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE manipulation CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE med_direction CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE opinion CHANGE ordering ordering INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE price_segment CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE promo CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE promo_main CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE role CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE service_clinic_type CHANGE status status TINYINT(1) NOT NULL, CHANGE ordering ordering INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE status status TINYINT(1) NOT NULL');
    }
}
