<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181114115000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clinic_certificate DROP FOREIGN KEY FK_529A53CD99223FFD');
        $this->addSql('ALTER TABLE city_article DROP FOREIGN KEY FK_BF72B0348BAC62AF');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B48BAC62AF');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB8BAC62AF');
        $this->addSql('ALTER TABLE clinic_certificate DROP FOREIGN KEY FK_529A53CDCC22AD4');
        $this->addSql('ALTER TABLE clinic_form_answer DROP FOREIGN KEY FK_AB35170CCC22AD4');
        $this->addSql('ALTER TABLE clinic_lang_support DROP FOREIGN KEY FK_D23AB30BCC22AD4');
        $this->addSql('ALTER TABLE clinic_manipulation DROP FOREIGN KEY FK_3263F2D4CC22AD4');
        $this->addSql('ALTER TABLE clinic_service_clinic_type DROP FOREIGN KEY FK_3B9DF8FCCC22AD4');
        $this->addSql('ALTER TABLE compare DROP FOREIGN KEY FK_BDC9085DCC22AD4');
        $this->addSql('ALTER TABLE cost_example DROP FOREIGN KEY FK_288213A0CC22AD4');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36ACC22AD4');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027CC22AD4');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBCC22AD4');
        $this->addSql('ALTER TABLE promo_main DROP FOREIGN KEY FK_F5B16E62CC22AD4');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F80123D8E604F');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F8012E35A8C85');
        $this->addSql('ALTER TABLE clinic_attr_val DROP FOREIGN KEY FK_3A2810562F1B123A');
        $this->addSql('ALTER TABLE clinic_attr DROP FOREIGN KEY FK_53FCF08D91214581');
        $this->addSql('ALTER TABLE clinic_param_val DROP FOREIGN KEY FK_D75AF2B7E57AD3BA');
        $this->addSql('ALTER TABLE med_cost_example DROP FOREIGN KEY FK_45D5485ADD603BE6');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE country_article DROP FOREIGN KEY FK_CB76560BF92F3E70');
        $this->addSql('ALTER TABLE country_disease DROP FOREIGN KEY FK_C67732ACF92F3E70');
        $this->addSql('ALTER TABLE country_med_direction DROP FOREIGN KEY FK_75BEC81CF92F3E70');
        $this->addSql('ALTER TABLE last_request DROP FOREIGN KEY FK_5D1BB3D7F92F3E70');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027F92F3E70');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBF92F3E70');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B4733D5B5D');
        $this->addSql('ALTER TABLE disease DROP FOREIGN KEY FK_F3B6AC1733D5B5D');
        $this->addSql('ALTER TABLE cost_example DROP FOREIGN KEY FK_288213A0D8355341');
        $this->addSql('ALTER TABLE country_disease DROP FOREIGN KEY FK_C67732ACD8355341');
        $this->addSql('ALTER TABLE disease_manipulation DROP FOREIGN KEY FK_E3C3FEF2D8355341');
        $this->addSql('ALTER TABLE fake_disease_direction DROP FOREIGN KEY FK_843D9554D8355341');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027D8355341');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBD8355341');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation DROP FOREIGN KEY FK_DAF00AC787F4FB17');
        $this->addSql('ALTER TABLE med_doctor DROP FOREIGN KEY FK_FE59468B87F4FB17');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A7C4E36BD');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation DROP FOREIGN KEY FK_DAF00AC7800776B0');
        $this->addSql('ALTER TABLE clinic_lang_support DROP FOREIGN KEY FK_D23AB30B62CC2747');
        $this->addSql('ALTER TABLE clinic_manipulation DROP FOREIGN KEY FK_3263F2D41FCCC2BE');
        $this->addSql('ALTER TABLE disease_manipulation DROP FOREIGN KEY FK_E3C3FEF21FCCC2BE');
        $this->addSql('ALTER TABLE country_med_direction DROP FOREIGN KEY FK_75BEC81CC224826D');
        $this->addSql('ALTER TABLE disease DROP FOREIGN KEY FK_F3B6AC1C224826D');
        $this->addSql('ALTER TABLE fake_disease_direction DROP FOREIGN KEY FK_843D9554C224826D');
        $this->addSql('ALTER TABLE med_cost_example DROP FOREIGN KEY FK_45D5485AC224826D');
        $this->addSql('ALTER TABLE med_doctor DROP FOREIGN KEY FK_FE59468BC224826D');
        $this->addSql('ALTER TABLE med_opinion DROP FOREIGN KEY FK_7CEEFB7CC224826D');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBC224826D');
        $this->addSql('ALTER TABLE med_opinion DROP FOREIGN KEY FK_7CEEFB7C51885A6A');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B46FA165A9');
        $this->addSql('ALTER TABLE clinic_service_clinic_type DROP FOREIGN KEY FK_3B9DF8FC9D4B26DD');
        $this->addSql('DROP TABLE certificate');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE city_article');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE clinic_attr');
        $this->addSql('DROP TABLE clinic_attr_group');
        $this->addSql('DROP TABLE clinic_attr_link');
        $this->addSql('DROP TABLE clinic_attr_val');
        $this->addSql('DROP TABLE clinic_certificate');
        $this->addSql('DROP TABLE clinic_disease');
        $this->addSql('DROP TABLE clinic_form_answer');
        $this->addSql('DROP TABLE clinic_lang_support');
        $this->addSql('DROP TABLE clinic_manipulation');
        $this->addSql('DROP TABLE clinic_med_direction');
        $this->addSql('DROP TABLE clinic_param');
        $this->addSql('DROP TABLE clinic_param_link');
        $this->addSql('DROP TABLE clinic_param_val');
        $this->addSql('DROP TABLE clinic_service_clinic_type');
        $this->addSql('DROP TABLE compare');
        $this->addSql('DROP TABLE cost_example');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE country_article');
        $this->addSql('DROP TABLE country_disease');
        $this->addSql('DROP TABLE country_med_direction');
        $this->addSql('DROP TABLE curator');
        $this->addSql('DROP TABLE disease');
        $this->addSql('DROP TABLE disease_country');
        $this->addSql('DROP TABLE disease_manipulation');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE doctor_degree');
        $this->addSql('DROP TABLE doctor_doctor_specialisation');
        $this->addSql('DROP TABLE doctor_specialisation');
        $this->addSql('DROP TABLE fake_disease_direction');
        $this->addSql('DROP TABLE lang_support');
        $this->addSql('DROP TABLE last_request');
        $this->addSql('DROP TABLE manipulation');
        $this->addSql('DROP TABLE med_cost_example');
        $this->addSql('DROP TABLE med_direction');
        $this->addSql('DROP TABLE med_doctor');
        $this->addSql('DROP TABLE med_opinion');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE price_segment');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_main');
        $this->addSql('DROP TABLE related_clinic');
        $this->addSql('DROP TABLE service_clinic_type');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE certificate (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_219CDA4AC53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, image INT DEFAULT NULL, country_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, name_rd VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_dt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_tv VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, h1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, airport_distance INT DEFAULT NULL, name_pr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_2D5B0234C4663E4 (page_id), INDEX IDX_2D5B0234F92F3E70 (country_id), INDEX IDX_2D5B0234C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city_article (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_BF72B0348BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic (id INT AUTO_INCREMENT NOT NULL, gallery INT DEFAULT NULL, price_segment_id INT DEFAULT NULL, curator_id INT DEFAULT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, discount SMALLINT DEFAULT NULL, discount_comment LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, quantity_patients INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, map_zoom INT DEFAULT NULL, rating NUMERIC(4, 2) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, advantage LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name_eng VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_rd VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_dt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_tv VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, answered_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_783F8B4472B783A (gallery), INDEX IDX_783F8B48BAC62AF (city_id), INDEX IDX_783F8B4733D5B5D (curator_id), INDEX IDX_783F8B46FA165A9 (price_segment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr (id INT AUTO_INCREMENT NOT NULL, clinic_attr_group_id INT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, multi_var TINYINT(1) DEFAULT \'0\' NOT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_53FCF08D91214581 (clinic_attr_group_id), INDEX IDX_53FCF08DC53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr_link (id INT AUTO_INCREMENT NOT NULL, clinic_id INT NOT NULL, clinic_attr_id INT NOT NULL, clinic_attr_val_id INT NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr_val (id INT AUTO_INCREMENT NOT NULL, clinic_attr_id INT NOT NULL, val VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, INDEX IDX_3A2810562F1B123A (clinic_attr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_certificate (clinic_id INT NOT NULL, certificate_id INT NOT NULL, INDEX IDX_529A53CDCC22AD4 (clinic_id), INDEX IDX_529A53CD99223FFD (certificate_id), PRIMARY KEY(clinic_id, certificate_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_disease (id INT AUTO_INCREMENT NOT NULL, clinic_id INT NOT NULL, disease_id INT NOT NULL, enabled TINYINT(1) DEFAULT \'0\' NOT NULL, favourite TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_form_answer (form_answer_id INT NOT NULL, clinic_id INT NOT NULL, INDEX IDX_AB35170CDB33F70B (form_answer_id), INDEX IDX_AB35170CCC22AD4 (clinic_id), PRIMARY KEY(form_answer_id, clinic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_lang_support (clinic_id INT NOT NULL, lang_support_id INT NOT NULL, INDEX IDX_D23AB30BCC22AD4 (clinic_id), INDEX IDX_D23AB30B62CC2747 (lang_support_id), PRIMARY KEY(clinic_id, lang_support_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_manipulation (id INT AUTO_INCREMENT NOT NULL, manipulation_id INT DEFAULT NULL, clinic_id INT DEFAULT NULL, min_price INT DEFAULT NULL, max_price INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_3263F2D4CC22AD4 (clinic_id), INDEX IDX_3263F2D41FCCC2BE (manipulation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_med_direction (id INT AUTO_INCREMENT NOT NULL, clinic_id INT NOT NULL, med_direction_id INT NOT NULL, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, favourite TINYINT(1) DEFAULT \'0\', deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_param (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, param_type INT NOT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_param_link (id INT AUTO_INCREMENT NOT NULL, clinic_id INT NOT NULL, clinic_param_id INT NOT NULL, clinic_param_val_id INT DEFAULT NULL, int_val INT DEFAULT NULL, str_val VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_param_val (id INT AUTO_INCREMENT NOT NULL, clinic_param_id INT NOT NULL, val VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D75AF2B7E57AD3BA (clinic_param_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_service_clinic_type (clinic_id INT NOT NULL, service_clinic_type_id INT NOT NULL, INDEX IDX_3B9DF8FCCC22AD4 (clinic_id), INDEX IDX_3B9DF8FC9D4B26DD (service_clinic_type_id), PRIMARY KEY(clinic_id, service_clinic_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compare (id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, user_token CHAR(50) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, UNIQUE INDEX user_clinic (user_token, clinic_id), INDEX IDX_BDC9085DCC22AD4 (clinic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cost_example (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, clinic_id INT DEFAULT NULL, disease_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, diagnosis VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, start_treatment DATE DEFAULT NULL, stop_treatment DATE DEFAULT NULL, comment LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, cost_diagnosis INT DEFAULT NULL, cost_treatment INT DEFAULT NULL, cost_pill INT DEFAULT NULL, cost_visa INT DEFAULT NULL, cost_live INT DEFAULT NULL, cost_transfer INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_288213A0CC22AD4 (clinic_id), INDEX IDX_288213A0D8355341 (disease_id), INDEX IDX_288213A0C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, image INT DEFAULT NULL, flag INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, price_segment INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, h1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_rd VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_dt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_tv VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_pr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, quantity_patients INT DEFAULT NULL, UNIQUE INDEX UNIQ_5373C966C4663E4 (page_id), INDEX IDX_5373C966C53D045F (image), INDEX IDX_5373C966D1F4EB9A (flag), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_article (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, country_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_CB76560BF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_disease (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, disease_id INT DEFAULT NULL, country_id INT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, favourite TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_C67732ACC4663E4 (page_id), INDEX IDX_C67732ACF92F3E70 (country_id), INDEX IDX_C67732ACD8355341 (disease_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_med_direction (id INT AUTO_INCREMENT NOT NULL, med_direction_id INT DEFAULT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, h1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, INDEX IDX_75BEC81CF92F3E70 (country_id), INDEX IDX_75BEC81CC224826D (med_direction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curator (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, response_time INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_73C39149C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease (id INT AUTO_INCREMENT NOT NULL, gallery INT DEFAULT NULL, curator_id INT DEFAULT NULL, med_direction_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, name_rd VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_dt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_tv VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, h1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, action DOUBLE PRECISION DEFAULT NULL, fav TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, rating NUMERIC(4, 2) DEFAULT NULL, technologies INT DEFAULT NULL, is_manipulation TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_F3B6AC1472B783A (gallery), INDEX IDX_F3B6AC1C224826D (med_direction_id), INDEX IDX_F3B6AC1733D5B5D (curator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease_country (id INT AUTO_INCREMENT NOT NULL, disease_id INT NOT NULL, country_id INT NOT NULL, enabled TINYINT(1) DEFAULT \'0\' NOT NULL, favourite TINYINT(1) DEFAULT \'0\' NOT NULL, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease_manipulation (disease_id INT NOT NULL, manipulation_id INT NOT NULL, INDEX IDX_E3C3FEF2D8355341 (disease_id), INDEX IDX_E3C3FEF21FCCC2BE (manipulation_id), PRIMARY KEY(disease_id, manipulation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, doctor_degree_id INT NOT NULL, image INT DEFAULT NULL, clinic_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, experience INT DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_1FC0F36A7C4E36BD (doctor_degree_id), INDEX IDX_1FC0F36AC53D045F (image), INDEX IDX_1FC0F36ACC22AD4 (clinic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_degree (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_33F5DEEC53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_doctor_specialisation (doctor_id INT NOT NULL, doctor_specialisation_id INT NOT NULL, INDEX IDX_DAF00AC787F4FB17 (doctor_id), INDEX IDX_DAF00AC7800776B0 (doctor_specialisation_id), PRIMARY KEY(doctor_id, doctor_specialisation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_specialisation (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_36887995C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fake_disease_direction (disease_id INT NOT NULL, med_direction_id INT NOT NULL, INDEX IDX_843D9554D8355341 (disease_id), INDEX IDX_843D9554C224826D (med_direction_id), PRIMARY KEY(disease_id, med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lang_support (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_A195A301C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE last_request (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, fio VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_5D1BB3D7F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manipulation (id INT AUTO_INCREMENT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med_cost_example (cost_example_id INT NOT NULL, med_direction_id INT NOT NULL, INDEX IDX_45D5485ADD603BE6 (cost_example_id), INDEX IDX_45D5485AC224826D (med_direction_id), PRIMARY KEY(cost_example_id, med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med_direction (id INT AUTO_INCREMENT NOT NULL, icon INT DEFAULT NULL, icon_inverse INT DEFAULT NULL, image INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, name_rd VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_dt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name_tv VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, favourite TINYINT(1) DEFAULT NULL, h1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, favourite_etc TINYINT(1) DEFAULT NULL, INDEX IDX_860B1AD8C53D045F (image), INDEX IDX_860B1AD8659429DB (icon), INDEX IDX_860B1AD8756F2F0 (icon_inverse), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med_doctor (doctor_id INT NOT NULL, med_direction_id INT NOT NULL, INDEX IDX_FE59468B87F4FB17 (doctor_id), INDEX IDX_FE59468BC224826D (med_direction_id), PRIMARY KEY(doctor_id, med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med_opinion (opinion_id INT NOT NULL, med_direction_id INT NOT NULL, INDEX IDX_7CEEFB7C51885A6A (opinion_id), INDEX IDX_7CEEFB7CC224826D (med_direction_id), PRIMARY KEY(opinion_id, med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinion (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, clinic_id INT DEFAULT NULL, disease_id INT DEFAULT NULL, country_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, opinion_date DATE DEFAULT NULL, start_treatment DATE DEFAULT NULL, stop_treatment DATE DEFAULT NULL, rating NUMERIC(4, 2) DEFAULT NULL, fio VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, full_price DOUBLE PRECISION DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, preview_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ordering INT DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, rating_doctor INT DEFAULT NULL, rating_translator INT DEFAULT NULL, rating_services INT DEFAULT NULL, city_living VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, sex TINYINT(1) NOT NULL, answer_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, answer_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, answer_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, priority TINYINT(1) DEFAULT \'0\' NOT NULL, show_on_main TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_AB02B027CC22AD4 (clinic_id), INDEX IDX_AB02B027F92F3E70 (country_id), INDEX IDX_AB02B027D8355341 (disease_id), INDEX IDX_AB02B027C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_segment (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_73A73D39C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, med_direction_id INT DEFAULT NULL, clinic_id INT DEFAULT NULL, disease_id INT DEFAULT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_B0139AFBCC22AD4 (clinic_id), INDEX IDX_B0139AFB8BAC62AF (city_id), INDEX IDX_B0139AFBF92F3E70 (country_id), INDEX IDX_B0139AFBC224826D (med_direction_id), INDEX IDX_B0139AFBD8355341 (disease_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_main (id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, old_price INT DEFAULT NULL, new_price INT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, discount SMALLINT DEFAULT NULL, INDEX IDX_F5B16E62CC22AD4 (clinic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_clinic (id INT AUTO_INCREMENT NOT NULL, parent INT DEFAULT NULL, rel_clinic INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_AB4F80123D8E604F (parent), INDEX IDX_AB4F8012E35A8C85 (rel_clinic), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_clinic_type (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status TINYINT(1) DEFAULT \'0\' NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_17C6A21CC53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4AC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE city_article ADD CONSTRAINT FK_BF72B0348BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4472B783A FOREIGN KEY (gallery) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B46FA165A9 FOREIGN KEY (price_segment_id) REFERENCES price_segment (id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4733D5B5D FOREIGN KEY (curator_id) REFERENCES curator (id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B48BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE clinic_attr ADD CONSTRAINT FK_53FCF08D91214581 FOREIGN KEY (clinic_attr_group_id) REFERENCES clinic_attr_group (id)');
        $this->addSql('ALTER TABLE clinic_attr ADD CONSTRAINT FK_53FCF08DC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE clinic_attr_val ADD CONSTRAINT FK_3A2810562F1B123A FOREIGN KEY (clinic_attr_id) REFERENCES clinic_attr (id)');
        $this->addSql('ALTER TABLE clinic_certificate ADD CONSTRAINT FK_529A53CD99223FFD FOREIGN KEY (certificate_id) REFERENCES certificate (id)');
        $this->addSql('ALTER TABLE clinic_certificate ADD CONSTRAINT FK_529A53CDCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE clinic_form_answer ADD CONSTRAINT FK_AB35170CCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE clinic_form_answer ADD CONSTRAINT FK_AB35170CDB33F70B FOREIGN KEY (form_answer_id) REFERENCES from_answer (id)');
        $this->addSql('ALTER TABLE clinic_lang_support ADD CONSTRAINT FK_D23AB30B62CC2747 FOREIGN KEY (lang_support_id) REFERENCES lang_support (id)');
        $this->addSql('ALTER TABLE clinic_lang_support ADD CONSTRAINT FK_D23AB30BCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE clinic_manipulation ADD CONSTRAINT FK_3263F2D41FCCC2BE FOREIGN KEY (manipulation_id) REFERENCES manipulation (id)');
        $this->addSql('ALTER TABLE clinic_manipulation ADD CONSTRAINT FK_3263F2D4CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE clinic_param_val ADD CONSTRAINT FK_D75AF2B7E57AD3BA FOREIGN KEY (clinic_param_id) REFERENCES clinic_param (id)');
        $this->addSql('ALTER TABLE clinic_service_clinic_type ADD CONSTRAINT FK_3B9DF8FC9D4B26DD FOREIGN KEY (service_clinic_type_id) REFERENCES service_clinic_type (id)');
        $this->addSql('ALTER TABLE clinic_service_clinic_type ADD CONSTRAINT FK_3B9DF8FCCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE compare ADD CONSTRAINT FK_BDC9085DCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE cost_example ADD CONSTRAINT FK_288213A0C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE cost_example ADD CONSTRAINT FK_288213A0CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE cost_example ADD CONSTRAINT FK_288213A0D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966D1F4EB9A FOREIGN KEY (flag) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE country_article ADD CONSTRAINT FK_CB76560BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732ACC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732ACD8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732ACF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country_med_direction ADD CONSTRAINT FK_75BEC81CC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE country_med_direction ADD CONSTRAINT FK_75BEC81CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE curator ADD CONSTRAINT FK_73C39149C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE disease ADD CONSTRAINT FK_F3B6AC1472B783A FOREIGN KEY (gallery) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE disease ADD CONSTRAINT FK_F3B6AC1733D5B5D FOREIGN KEY (curator_id) REFERENCES curator (id)');
        $this->addSql('ALTER TABLE disease ADD CONSTRAINT FK_F3B6AC1C224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE disease_manipulation ADD CONSTRAINT FK_E3C3FEF21FCCC2BE FOREIGN KEY (manipulation_id) REFERENCES manipulation (id)');
        $this->addSql('ALTER TABLE disease_manipulation ADD CONSTRAINT FK_E3C3FEF2D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A7C4E36BD FOREIGN KEY (doctor_degree_id) REFERENCES doctor_degree (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36AC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36ACC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE doctor_degree ADD CONSTRAINT FK_33F5DEEC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation ADD CONSTRAINT FK_DAF00AC7800776B0 FOREIGN KEY (doctor_specialisation_id) REFERENCES doctor_specialisation (id)');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation ADD CONSTRAINT FK_DAF00AC787F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE doctor_specialisation ADD CONSTRAINT FK_36887995C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE fake_disease_direction ADD CONSTRAINT FK_843D9554C224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE fake_disease_direction ADD CONSTRAINT FK_843D9554D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE lang_support ADD CONSTRAINT FK_A195A301C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE last_request ADD CONSTRAINT FK_5D1BB3D7F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE med_cost_example ADD CONSTRAINT FK_45D5485AC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE med_cost_example ADD CONSTRAINT FK_45D5485ADD603BE6 FOREIGN KEY (cost_example_id) REFERENCES cost_example (id)');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8659429DB FOREIGN KEY (icon) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8756F2F0 FOREIGN KEY (icon_inverse) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE med_doctor ADD CONSTRAINT FK_FE59468B87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE med_doctor ADD CONSTRAINT FK_FE59468BC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE med_opinion ADD CONSTRAINT FK_7CEEFB7C51885A6A FOREIGN KEY (opinion_id) REFERENCES opinion (id)');
        $this->addSql('ALTER TABLE med_opinion ADD CONSTRAINT FK_7CEEFB7CC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE price_segment ADD CONSTRAINT FK_73A73D39C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBD8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE promo_main ADD CONSTRAINT FK_F5B16E62CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F80123D8E604F FOREIGN KEY (parent) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F8012E35A8C85 FOREIGN KEY (rel_clinic) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE service_clinic_type ADD CONSTRAINT FK_17C6A21CC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
    }
}
