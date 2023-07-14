<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170323115130 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE classification__category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, context VARCHAR(255) DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_43629B36727ACA70 (parent_id), INDEX IDX_43629B36E25D857E (context), INDEX IDX_43629B36EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classification__collection (id INT AUTO_INCREMENT NOT NULL, context VARCHAR(255) DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A406B56AE25D857E (context), INDEX IDX_A406B56AEA9FDD75 (media_id), UNIQUE INDEX tag_collection (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classification__context (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classification__tag (id INT AUTO_INCREMENT NOT NULL, context VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CA57A1C7E25D857E (context), UNIQUE INDEX tag_context (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__gallery_media (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_80D4C5414E7AF8F (gallery_id), INDEX IDX_80D4C541EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable TINYINT(1) DEFAULT NULL, cdn_flush_identifier VARCHAR(64) DEFAULT NULL, cdn_flush_at DATETIME DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certificate (certificate_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_219CDA4AC53D045F (image), PRIMARY KEY(certificate_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (city_id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), PRIMARY KEY(city_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city_price (certificate_id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_8942858E8BAC62AF (city_id), PRIMARY KEY(certificate_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic (clinic_id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, curator_id INT DEFAULT NULL, price_segment_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, discount INT DEFAULT NULL, discount_comment LONGTEXT DEFAULT NULL, quantity_patients INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_783F8B48BAC62AF (city_id), INDEX IDX_783F8B4733D5B5D (curator_id), INDEX IDX_783F8B46FA165A9 (price_segment_id), PRIMARY KEY(clinic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_service_clinic_type (clinic_id INT NOT NULL, service_clinic_type_id INT NOT NULL, INDEX IDX_3B9DF8FCCC22AD4 (clinic_id), INDEX IDX_3B9DF8FC9D4B26DD (service_clinic_type_id), PRIMARY KEY(clinic_id, service_clinic_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_lang_support (clinic_id INT NOT NULL, lang_support_id INT NOT NULL, INDEX IDX_D23AB30BCC22AD4 (clinic_id), INDEX IDX_D23AB30B62CC2747 (lang_support_id), PRIMARY KEY(clinic_id, lang_support_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_certificate (clinic_id INT NOT NULL, certificate_id INT NOT NULL, INDEX IDX_529A53CDCC22AD4 (clinic_id), INDEX IDX_529A53CD99223FFD (certificate_id), PRIMARY KEY(clinic_id, certificate_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr (clinic_attr_id INT AUTO_INCREMENT NOT NULL, clinic_attr_group_id INT NOT NULL, name VARCHAR(255) NOT NULL, multi_var TINYINT(1) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_53FCF08D91214581 (clinic_attr_group_id), PRIMARY KEY(clinic_attr_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr_group (clinic_attr_group_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, PRIMARY KEY(clinic_attr_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr_link (clinic_id INT NOT NULL, clinic_attr_id INT NOT NULL, clinic_attr_val_id INT NOT NULL, PRIMARY KEY(clinic_id, clinic_attr_id, clinic_attr_val_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_attr_val (clinic_attr_val_id INT AUTO_INCREMENT NOT NULL, clinic_attr_id INT NOT NULL, val VARCHAR(255) NOT NULL, INDEX IDX_3A2810562F1B123A (clinic_attr_id), PRIMARY KEY(clinic_attr_val_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_disease (clinic_id INT NOT NULL, disease_id INT NOT NULL, enabled TINYINT(1) NOT NULL, favourite TINYINT(1) NOT NULL, PRIMARY KEY(clinic_id, disease_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_image (clinic_image_id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, image INT DEFAULT NULL, INDEX IDX_4CB9AD6CCC22AD4 (clinic_id), INDEX IDX_4CB9AD6CC53D045F (image), PRIMARY KEY(clinic_image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_manipulation (clinic_manipulation_id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, manipulation_id INT DEFAULT NULL, min_price INT DEFAULT NULL, max_price INT DEFAULT NULL, INDEX IDX_3263F2D4CC22AD4 (clinic_id), INDEX IDX_3263F2D41FCCC2BE (manipulation_id), PRIMARY KEY(clinic_manipulation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_param (clinic_param_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, param_type INT NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, PRIMARY KEY(clinic_param_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_param_link (clinic_id INT NOT NULL, clinic_param_id INT NOT NULL, clinic_param_val_id INT DEFAULT NULL, int_val INT DEFAULT NULL, str_val VARCHAR(255) DEFAULT NULL, PRIMARY KEY(clinic_id, clinic_param_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_param_val (clinic_param_val_id INT AUTO_INCREMENT NOT NULL, clinic_param_id INT NOT NULL, val VARCHAR(255) NOT NULL, INDEX IDX_D75AF2B7E57AD3BA (clinic_param_id), PRIMARY KEY(clinic_param_val_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_video (clinic_video_id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, html_code LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_F543731FCC22AD4 (clinic_id), PRIMARY KEY(clinic_video_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cost_example (cost_example_id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, diagnosis VARCHAR(255) NOT NULL, start_treatment DATE DEFAULT NULL, stop_treatment DATE DEFAULT NULL, comment LONGTEXT DEFAULT NULL, cost_diagnosis INT DEFAULT NULL, cost_treatment INT DEFAULT NULL, cost_pill INT DEFAULT NULL, cost_visa INT DEFAULT NULL, cost_live INT DEFAULT NULL, cost_transfer INT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_288213A0CC22AD4 (clinic_id), PRIMARY KEY(cost_example_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_disease (certificate_id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, disease_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_C67732ACF92F3E70 (country_id), INDEX IDX_C67732ACD8355341 (disease_id), PRIMARY KEY(certificate_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curator (curator_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, response_time INT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_73C39149C53D045F (image), PRIMARY KEY(curator_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease (disease_id INT AUTO_INCREMENT NOT NULL, med_direction_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_F3B6AC1C224826D (med_direction_id), PRIMARY KEY(disease_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease_manipulation (disease_id INT NOT NULL, manipulation_id INT NOT NULL, INDEX IDX_E3C3FEF2D8355341 (disease_id), INDEX IDX_E3C3FEF21FCCC2BE (manipulation_id), PRIMARY KEY(disease_id, manipulation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (doctor_id INT AUTO_INCREMENT NOT NULL, doctor_degree_id INT NOT NULL, image INT DEFAULT NULL, clinic_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, experience INT DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_1FC0F36A7C4E36BD (doctor_degree_id), INDEX IDX_1FC0F36AC53D045F (image), INDEX IDX_1FC0F36ACC22AD4 (clinic_id), PRIMARY KEY(doctor_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_doctor_specialisation (doctor_id INT NOT NULL, doctor_specialisation_id INT NOT NULL, INDEX IDX_DAF00AC787F4FB17 (doctor_id), INDEX IDX_DAF00AC7800776B0 (doctor_specialisation_id), PRIMARY KEY(doctor_id, doctor_specialisation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_degree (doctor_degree_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_33F5DEEC53D045F (image), PRIMARY KEY(doctor_degree_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_specialisation (doctor_specialisation_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_36887995C53D045F (image), PRIMARY KEY(doctor_specialisation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lang_support (lang_support_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_A195A301C53D045F (image), PRIMARY KEY(lang_support_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manipulation (manipulation_id INT AUTO_INCREMENT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(manipulation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med_direction (med_direction_id INT AUTO_INCREMENT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinion (opinion_id INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, clinic_id INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, opinion_date DATE DEFAULT NULL, start_treatment DATE DEFAULT NULL, stop_treatment DATE DEFAULT NULL, rating INT DEFAULT NULL, fio VARCHAR(255) DEFAULT NULL, full_price DOUBLE PRECISION DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_AB02B027BF396750 (id), INDEX IDX_AB02B027CC22AD4 (clinic_id), PRIMARY KEY(opinion_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med_opinion (opinion_id INT NOT NULL, med_direction_id INT NOT NULL, INDEX IDX_7CEEFB7C51885A6A (opinion_id), INDEX IDX_7CEEFB7CC224826D (med_direction_id), PRIMARY KEY(opinion_id, med_direction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_segment (price_segment_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_73A73D39C53D045F (image), PRIMARY KEY(price_segment_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (promo_id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, city_id INT DEFAULT NULL, country_id INT NOT NULL, med_direction_id INT NOT NULL, disease_id INT NOT NULL, name VARCHAR(255) NOT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_B0139AFBCC22AD4 (clinic_id), INDEX IDX_B0139AFB8BAC62AF (city_id), INDEX IDX_B0139AFBF92F3E70 (country_id), INDEX IDX_B0139AFBC224826D (med_direction_id), INDEX IDX_B0139AFBD8355341 (disease_id), PRIMARY KEY(promo_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_clinic (related_clinic_id INT AUTO_INCREMENT NOT NULL, parentId INT DEFAULT NULL, relClinicId INT DEFAULT NULL, INDEX IDX_AB4F801210EE4CEE (parentId), INDEX IDX_AB4F8012C5760F86 (relClinicId), PRIMARY KEY(related_clinic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_clinic_type (service_clinic_type_id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, INDEX IDX_17C6A21CC53D045F (image), PRIMARY KEY(service_clinic_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36727ACA70 FOREIGN KEY (parent_id) REFERENCES classification__category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36E25D857E FOREIGN KEY (context) REFERENCES classification__context (id)');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE classification__collection ADD CONSTRAINT FK_A406B56AE25D857E FOREIGN KEY (context) REFERENCES classification__context (id)');
        $this->addSql('ALTER TABLE classification__collection ADD CONSTRAINT FK_A406B56AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE classification__tag ADD CONSTRAINT FK_CA57A1C7E25D857E FOREIGN KEY (context) REFERENCES classification__context (id)');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4AC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE city_price ADD CONSTRAINT FK_8942858E8BAC62AF FOREIGN KEY (city_id) REFERENCES city (city_id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B48BAC62AF FOREIGN KEY (city_id) REFERENCES city (city_id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4733D5B5D FOREIGN KEY (curator_id) REFERENCES curator (curator_id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B46FA165A9 FOREIGN KEY (price_segment_id) REFERENCES price_segment (price_segment_id)');
        $this->addSql('ALTER TABLE clinic_service_clinic_type ADD CONSTRAINT FK_3B9DF8FCCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE clinic_service_clinic_type ADD CONSTRAINT FK_3B9DF8FC9D4B26DD FOREIGN KEY (service_clinic_type_id) REFERENCES service_clinic_type (service_clinic_type_id)');
        $this->addSql('ALTER TABLE clinic_lang_support ADD CONSTRAINT FK_D23AB30BCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE clinic_lang_support ADD CONSTRAINT FK_D23AB30B62CC2747 FOREIGN KEY (lang_support_id) REFERENCES lang_support (lang_support_id)');
        $this->addSql('ALTER TABLE clinic_certificate ADD CONSTRAINT FK_529A53CDCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE clinic_certificate ADD CONSTRAINT FK_529A53CD99223FFD FOREIGN KEY (certificate_id) REFERENCES certificate (certificate_id)');
        $this->addSql('ALTER TABLE clinic_attr ADD CONSTRAINT FK_53FCF08D91214581 FOREIGN KEY (clinic_attr_group_id) REFERENCES clinic_attr_group (clinic_attr_group_id)');
        $this->addSql('ALTER TABLE clinic_attr_val ADD CONSTRAINT FK_3A2810562F1B123A FOREIGN KEY (clinic_attr_id) REFERENCES clinic_attr (clinic_attr_id)');
        $this->addSql('ALTER TABLE clinic_image ADD CONSTRAINT FK_4CB9AD6CCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE clinic_image ADD CONSTRAINT FK_4CB9AD6CC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE clinic_manipulation ADD CONSTRAINT FK_3263F2D4CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE clinic_manipulation ADD CONSTRAINT FK_3263F2D41FCCC2BE FOREIGN KEY (manipulation_id) REFERENCES manipulation (manipulation_id)');
        $this->addSql('ALTER TABLE clinic_param_val ADD CONSTRAINT FK_D75AF2B7E57AD3BA FOREIGN KEY (clinic_param_id) REFERENCES clinic_param (clinic_param_id)');
        $this->addSql('ALTER TABLE clinic_video ADD CONSTRAINT FK_F543731FCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE cost_example ADD CONSTRAINT FK_288213A0CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732ACF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732ACD8355341 FOREIGN KEY (disease_id) REFERENCES disease (disease_id)');
        $this->addSql('ALTER TABLE curator ADD CONSTRAINT FK_73C39149C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE disease ADD CONSTRAINT FK_F3B6AC1C224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (med_direction_id)');
        $this->addSql('ALTER TABLE disease_manipulation ADD CONSTRAINT FK_E3C3FEF2D8355341 FOREIGN KEY (disease_id) REFERENCES disease (disease_id)');
        $this->addSql('ALTER TABLE disease_manipulation ADD CONSTRAINT FK_E3C3FEF21FCCC2BE FOREIGN KEY (manipulation_id) REFERENCES manipulation (manipulation_id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A7C4E36BD FOREIGN KEY (doctor_degree_id) REFERENCES doctor_degree (doctor_degree_id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36AC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36ACC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation ADD CONSTRAINT FK_DAF00AC787F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (doctor_id)');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation ADD CONSTRAINT FK_DAF00AC7800776B0 FOREIGN KEY (doctor_specialisation_id) REFERENCES doctor_specialisation (doctor_specialisation_id)');
        $this->addSql('ALTER TABLE doctor_degree ADD CONSTRAINT FK_33F5DEEC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE doctor_specialisation ADD CONSTRAINT FK_36887995C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE lang_support ADD CONSTRAINT FK_A195A301C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027BF396750 FOREIGN KEY (id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE med_opinion ADD CONSTRAINT FK_7CEEFB7C51885A6A FOREIGN KEY (opinion_id) REFERENCES opinion (opinion_id)');
        $this->addSql('ALTER TABLE med_opinion ADD CONSTRAINT FK_7CEEFB7CC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (med_direction_id)');
        $this->addSql('ALTER TABLE price_segment ADD CONSTRAINT FK_73A73D39C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (city_id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (med_direction_id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBD8355341 FOREIGN KEY (disease_id) REFERENCES disease (disease_id)');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F801210EE4CEE FOREIGN KEY (parentId) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F8012C5760F86 FOREIGN KEY (relClinicId) REFERENCES clinic (clinic_id)');
        $this->addSql('ALTER TABLE service_clinic_type ADD CONSTRAINT FK_17C6A21CC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE country ADD meta_title VARCHAR(255) DEFAULT NULL, ADD meta_description LONGTEXT DEFAULT NULL, ADD meta_keywords LONGTEXT DEFAULT NULL, ADD link VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classification__category DROP FOREIGN KEY FK_43629B36727ACA70');
        $this->addSql('ALTER TABLE classification__category DROP FOREIGN KEY FK_43629B36E25D857E');
        $this->addSql('ALTER TABLE classification__collection DROP FOREIGN KEY FK_A406B56AE25D857E');
        $this->addSql('ALTER TABLE classification__tag DROP FOREIGN KEY FK_CA57A1C7E25D857E');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE classification__category DROP FOREIGN KEY FK_43629B36EA9FDD75');
        $this->addSql('ALTER TABLE classification__collection DROP FOREIGN KEY FK_A406B56AEA9FDD75');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE certificate DROP FOREIGN KEY FK_219CDA4AC53D045F');
        $this->addSql('ALTER TABLE clinic_image DROP FOREIGN KEY FK_4CB9AD6CC53D045F');
        $this->addSql('ALTER TABLE curator DROP FOREIGN KEY FK_73C39149C53D045F');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36AC53D045F');
        $this->addSql('ALTER TABLE doctor_degree DROP FOREIGN KEY FK_33F5DEEC53D045F');
        $this->addSql('ALTER TABLE doctor_specialisation DROP FOREIGN KEY FK_36887995C53D045F');
        $this->addSql('ALTER TABLE lang_support DROP FOREIGN KEY FK_A195A301C53D045F');
        $this->addSql('ALTER TABLE price_segment DROP FOREIGN KEY FK_73A73D39C53D045F');
        $this->addSql('ALTER TABLE service_clinic_type DROP FOREIGN KEY FK_17C6A21CC53D045F');
        $this->addSql('ALTER TABLE clinic_certificate DROP FOREIGN KEY FK_529A53CD99223FFD');
        $this->addSql('ALTER TABLE city_price DROP FOREIGN KEY FK_8942858E8BAC62AF');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B48BAC62AF');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB8BAC62AF');
        $this->addSql('ALTER TABLE clinic_service_clinic_type DROP FOREIGN KEY FK_3B9DF8FCCC22AD4');
        $this->addSql('ALTER TABLE clinic_lang_support DROP FOREIGN KEY FK_D23AB30BCC22AD4');
        $this->addSql('ALTER TABLE clinic_certificate DROP FOREIGN KEY FK_529A53CDCC22AD4');
        $this->addSql('ALTER TABLE clinic_image DROP FOREIGN KEY FK_4CB9AD6CCC22AD4');
        $this->addSql('ALTER TABLE clinic_manipulation DROP FOREIGN KEY FK_3263F2D4CC22AD4');
        $this->addSql('ALTER TABLE clinic_video DROP FOREIGN KEY FK_F543731FCC22AD4');
        $this->addSql('ALTER TABLE cost_example DROP FOREIGN KEY FK_288213A0CC22AD4');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36ACC22AD4');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027CC22AD4');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBCC22AD4');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F801210EE4CEE');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F8012C5760F86');
        $this->addSql('ALTER TABLE clinic_attr_val DROP FOREIGN KEY FK_3A2810562F1B123A');
        $this->addSql('ALTER TABLE clinic_attr DROP FOREIGN KEY FK_53FCF08D91214581');
        $this->addSql('ALTER TABLE clinic_param_val DROP FOREIGN KEY FK_D75AF2B7E57AD3BA');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B4733D5B5D');
        $this->addSql('ALTER TABLE country_disease DROP FOREIGN KEY FK_C67732ACD8355341');
        $this->addSql('ALTER TABLE disease_manipulation DROP FOREIGN KEY FK_E3C3FEF2D8355341');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBD8355341');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation DROP FOREIGN KEY FK_DAF00AC787F4FB17');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A7C4E36BD');
        $this->addSql('ALTER TABLE doctor_doctor_specialisation DROP FOREIGN KEY FK_DAF00AC7800776B0');
        $this->addSql('ALTER TABLE clinic_lang_support DROP FOREIGN KEY FK_D23AB30B62CC2747');
        $this->addSql('ALTER TABLE clinic_manipulation DROP FOREIGN KEY FK_3263F2D41FCCC2BE');
        $this->addSql('ALTER TABLE disease_manipulation DROP FOREIGN KEY FK_E3C3FEF21FCCC2BE');
        $this->addSql('ALTER TABLE disease DROP FOREIGN KEY FK_F3B6AC1C224826D');
        $this->addSql('ALTER TABLE med_opinion DROP FOREIGN KEY FK_7CEEFB7CC224826D');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBC224826D');
        $this->addSql('ALTER TABLE med_opinion DROP FOREIGN KEY FK_7CEEFB7C51885A6A');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B46FA165A9');
        $this->addSql('ALTER TABLE clinic_service_clinic_type DROP FOREIGN KEY FK_3B9DF8FC9D4B26DD');
        $this->addSql('DROP TABLE classification__category');
        $this->addSql('DROP TABLE classification__collection');
        $this->addSql('DROP TABLE classification__context');
        $this->addSql('DROP TABLE classification__tag');
        $this->addSql('DROP TABLE media__gallery');
        $this->addSql('DROP TABLE media__gallery_media');
        $this->addSql('DROP TABLE media__media');
        $this->addSql('DROP TABLE certificate');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE city_price');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE clinic_service_clinic_type');
        $this->addSql('DROP TABLE clinic_lang_support');
        $this->addSql('DROP TABLE clinic_certificate');
        $this->addSql('DROP TABLE clinic_attr');
        $this->addSql('DROP TABLE clinic_attr_group');
        $this->addSql('DROP TABLE clinic_attr_link');
        $this->addSql('DROP TABLE clinic_attr_val');
        $this->addSql('DROP TABLE clinic_disease');
        $this->addSql('DROP TABLE clinic_image');
        $this->addSql('DROP TABLE clinic_manipulation');
        $this->addSql('DROP TABLE clinic_param');
        $this->addSql('DROP TABLE clinic_param_link');
        $this->addSql('DROP TABLE clinic_param_val');
        $this->addSql('DROP TABLE clinic_video');
        $this->addSql('DROP TABLE cost_example');
        $this->addSql('DROP TABLE country_disease');
        $this->addSql('DROP TABLE curator');
        $this->addSql('DROP TABLE disease');
        $this->addSql('DROP TABLE disease_manipulation');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE doctor_doctor_specialisation');
        $this->addSql('DROP TABLE doctor_degree');
        $this->addSql('DROP TABLE doctor_specialisation');
        $this->addSql('DROP TABLE lang_support');
        $this->addSql('DROP TABLE manipulation');
        $this->addSql('DROP TABLE med_direction');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE med_opinion');
        $this->addSql('DROP TABLE price_segment');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE related_clinic');
        $this->addSql('DROP TABLE service_clinic_type');
        $this->addSql('ALTER TABLE country DROP meta_title, DROP meta_description, DROP meta_keywords, DROP link');
    }
}
