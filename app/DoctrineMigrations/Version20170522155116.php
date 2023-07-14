<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use AppBundle\Doctrine\SecurityGeneratorListener;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\CmfScript;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170522155116 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface Контейнер
     */
    private $container;
    
    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disease ADD rating NUMERIC(4, 2) DEFAULT NULL, ADD technologies INT DEFAULT NULL');
        
        $this->addSql("UPDATE cmf_script SET url = '/specialities/' WHERE id IN(88, 93, 97)");
        
        $this->addSql("UPDATE cmf_script SET name = 'Каталог заболеваний', text_raw='<p>Если вы знаете диагноз &ndash; можно кликнуть на заболевание и увидеть список клиник, которые на нем специализируются.</p>', text_formatted='<p>Если вы знаете диагноз &ndash; можно кликнуть на заболевание и увидеть список клиник, которые на нем специализируются.</p>' WHERE id = 88");
        
        $this->addSql('ALTER TABLE opinion ADD disease_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('CREATE INDEX IDX_AB02B027D8355341 ON opinion (disease_id)');
        
        $this->addSql('ALTER TABLE city ADD image INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234C53D045F ON city (image)');
        
        $this->addSql('ALTER TABLE cost_example ADD image INT DEFAULT NULL, ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cost_example ADD CONSTRAINT FK_288213A0C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_288213A0C53D045F ON cost_example (image)');
        
        $this->addSql('ALTER TABLE opinion ADD image INT DEFAULT NULL, ADD rating_doctor INT DEFAULT NULL, ADD rating_translator INT DEFAULT NULL, ADD rating_services INT DEFAULT NULL, ADD city_living VARCHAR(255) NOT NULL, ADD sex TINYINT(1) NOT NULL, ADD answer_type LONGTEXT DEFAULT NULL, ADD answer_raw LONGTEXT DEFAULT NULL, ADD answer_formatted LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_AB02B027C53D045F ON opinion (image)');
        
        $this->addSql('ALTER TABLE opinion CHANGE rating rating NUMERIC(4, 2) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE opinion CHANGE city_living city_living VARCHAR(255) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE opinion ADD priority TINYINT(1) NOT NULL');
        
        $this->addSql('ALTER TABLE disease ADD curator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE disease ADD CONSTRAINT FK_F3B6AC1733D5B5D FOREIGN KEY (curator_id) REFERENCES curator (id)');
        $this->addSql('CREATE INDEX IDX_F3B6AC1733D5B5D ON disease (curator_id)');
        
        $this->addSql("UPDATE cmf_script SET url = '/feedbacks/' WHERE id IN(90, 95, 99)");
        
        $this->addSql("UPDATE cmf_script SET name = 'Отзывы о зарубежных клиниках' WHERE id = 90");
        
        $this->addSql('ALTER TABLE country_disease ADD favourite TINYINT(1) NOT NULL');
        
        $this->addSql("UPDATE cmf_script SET url = '/countries/' WHERE id IN(79, 83, 87)");
        
        $this->addSql('CREATE TABLE promo_main (id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, old_price INT DEFAULT NULL, new_price INT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F5B16E62CC22AD4 (clinic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo_main ADD CONSTRAINT FK_F5B16E62CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`meta_title`,`meta_description`,`meta_keywords`,`deleted_at`) VALUES 
            (105,'Акции для главной',5,3,1,1,'','/admin/app/promomain/list',NULL,'105','richhtml',NULL,'','richhtml',NULL,'',18,79,80,1,'',0,0,0,0,NULL,NULL,NULL,NULL)");
        
        $this->addSql('INSERT IGNORE INTO `role_script` (`role_id`,`cmf_script_id`) VALUES (1, 105), (2, 105)');
        
        $this->addSql('CREATE TABLE last_request (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, fio VARCHAR(255) NOT NULL, start_treatment DATETIME DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_5D1BB3D7F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE last_request ADD CONSTRAINT FK_5D1BB3D7F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`meta_title`,`meta_description`,`meta_keywords`,`deleted_at`) VALUES 
            (106,'Последние обращения',5,3,1,1,'','/admin/app/lastrequest/list',NULL,'106','richhtml',NULL,'','richhtml',NULL,'',19,81,82,1,'',0,0,0,0,NULL,NULL,NULL,NULL)");
        
        $this->addSql('INSERT IGNORE INTO `role_script` (`role_id`,`cmf_script_id`) VALUES (1, 106), (2, 106)');
    
        $this->addSql('ALTER TABLE disease DROP favMain');
        $this->addSql('ALTER TABLE med_direction ADD icon INT DEFAULT NULL, ADD favourite_etc TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8659429DB FOREIGN KEY (icon) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_860B1AD8659429DB ON med_direction (icon)');
        
        $this->addSql("UPDATE cmf_script SET preview_raw = '<h2>Заголовок SEO блока</h2>', preview_formatted = '<h2>Заголовок SEO блока</h2>', text_raw = '<p>текст сео-блока</p>', text_formatted = '<p>текст сео-блока</p>'  WHERE id = 84");
        
        $this->addSql('CREATE TABLE country_disease_price (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_price (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD city_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02348942858E FOREIGN KEY (city_price) REFERENCES city_price (id)');
        $this->addSql('CREATE INDEX IDX_2D5B02348942858E ON city (city_price)');
        $this->addSql('ALTER TABLE city_price DROP FOREIGN KEY FK_8942858E8BAC62AF');
        $this->addSql('DROP INDEX IDX_8942858E8BAC62AF ON city_price');
        $this->addSql('ALTER TABLE city_price DROP city_id');
        $this->addSql('ALTER TABLE country ADD country_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C9666D283733 FOREIGN KEY (country_price) REFERENCES country_price (id)');
        $this->addSql('CREATE INDEX IDX_5373C9666D283733 ON country (country_price)');
        $this->addSql('ALTER TABLE country_disease ADD country_disease_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732AC960586E1 FOREIGN KEY (country_disease_price) REFERENCES country_disease_price (id)');
        $this->addSql('CREATE INDEX IDX_C67732AC960586E1 ON country_disease (country_disease_price)');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`meta_title`,`meta_description`,`meta_keywords`,`deleted_at`) VALUES 
            (107,'Страна-цена',5,3,1,1,'','/admin/app/countryprice/list',NULL,'107','richhtml',NULL,'','richhtml',NULL,'',21,83,84,1,'',0,0,0,0,NULL,NULL,NULL,NULL),
            (108,'Страна-заболевание-цена',5,3,1,1,'','/admin/app/countrydiseaseprice/list',NULL,'108','richhtml',NULL,'','richhtml',NULL,'',22,85,86,1,'',0,0,0,0,NULL,NULL,NULL,NULL)");
        
        $this->addSql("UPDATE `cmf_script` SET ordering = 20 WHERE id = 55");
        
        $this->addSql('INSERT IGNORE INTO `role_script` (`role_id`,`cmf_script_id`) VALUES (1, 107), (2, 107), (1, 108), (2, 108)');
        
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, deleted_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT \'1\' NOT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE country_disease DROP FOREIGN KEY FK_C67732AC960586E1');
        $this->addSql('DROP INDEX IDX_C67732AC960586E1 ON country_disease');
        $this->addSql('ALTER TABLE country_disease CHANGE country_disease_price page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732ACC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C67732ACC4663E4 ON country_disease (page_id)');
        
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02348942858E');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C9666D283733');
        $this->addSql('DROP TABLE city_price');
        $this->addSql('DROP TABLE country_disease_price');
        $this->addSql('DROP TABLE country_price');
        $this->addSql('DROP INDEX IDX_2D5B02348942858E ON city');
        $this->addSql('ALTER TABLE city CHANGE city_price page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234C4663E4 ON city (page_id)');
        $this->addSql('DROP INDEX IDX_5373C9666D283733 ON country');
        $this->addSql('ALTER TABLE country CHANGE country_price page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5373C966C4663E4 ON country (page_id)');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`meta_title`,`meta_description`,`meta_keywords`,`deleted_at`) VALUES 
            (109,'Статичный контент',5,3,1,1,'','/admin/app/page/list',NULL,'109','richhtml',NULL,'','richhtml',NULL,'',23,87,88,1,'',0,0,0,0,NULL,NULL,NULL,NULL)");
        
        $this->addSql('INSERT IGNORE INTO `role_script` (`role_id`,`cmf_script_id`) VALUES (1, 109), (2, 109)');
        
        $this->addSql("DELETE FROM `role_script` WHERE cmf_script_id IN(55,107,108)");
        $this->addSql("DELETE FROM `cmf_script` WHERE id IN(55,107,108)");
        
        $this->addSql('ALTER TABLE city DROP INDEX IDX_2D5B0234C4663E4, ADD UNIQUE INDEX UNIQ_2D5B0234C4663E4 (page_id)');
        $this->addSql('ALTER TABLE page ADD h1 VARCHAR(255) DEFAULT NULL, ADD preview_raw LONGTEXT DEFAULT NULL, ADD preview_type LONGTEXT DEFAULT NULL, ADD preview_formatted LONGTEXT DEFAULT NULL');
        
        $this->addSql("UPDATE city SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE clinic SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE country SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE country_article SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE disease SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE doctor SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE manipulation SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE med_direction SET link = TRIM(BOTH '/' FROM link)");
        $this->addSql("UPDATE opinion SET link = TRIM(BOTH '/' FROM link)");
        
        $this->addSql('ALTER TABLE clinic_attr_link DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE clinic_attr_link ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE clinic_disease DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE clinic_disease ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE clinic_med_direction DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE clinic_med_direction ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE clinic_param_link DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE clinic_param_link ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE cmf_configure DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cmf_configure ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE cmf_rights DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cmf_rights ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE disease_country DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE disease_country ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql('ALTER TABLE privilege DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE privilege ADD COLUMN id INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY (id)');
        
        $this->addSql("UPDATE `cmf_script` SET ordering = 2 WHERE id = 5");
        $this->addSql("UPDATE `cmf_script` SET ordering = 3 WHERE id = 46");
        
    }
    
    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $entityManager = $this->container->get('doctrine')->getEntityManager();
        $tokenStorage = $this->container->get('security.token_storage');
        
        $repo = $entityManager->getRepository(CmfScript::class);
        $repo->RebuildTreeOrdering();
        
        $SecurityGeneratorListener = new SecurityGeneratorListener($tokenStorage, $entityManager);
        
        $SecurityGeneratorListener->generateSecurityYML();
    }
    
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE city DROP INDEX UNIQ_2D5B0234C4663E4, ADD INDEX IDX_2D5B0234C4663E4 (page_id)');
        $this->addSql('ALTER TABLE page DROP h1, DROP preview_raw, DROP preview_type, DROP preview_formatted');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`meta_title`,`meta_description`,`meta_keywords`,`deleted_at`) VALUES 
            (55,'Город-цена',5,3,1,1,'','/admin/app/cityprice/list',NULL,'55','richhtml',NULL,'','richhtml',NULL,'',20,81,82,1,'',0,0,0,0,NULL,NULL,NULL,NULL),
            (107,'Страна-цена',5,3,1,1,'','/admin/app/countryprice/list',NULL,'107','richhtml',NULL,'','richhtml',NULL,'',21,83,84,1,'',0,0,0,0,NULL,NULL,NULL,NULL),
            (108,'Страна-заболевание-цена',5,3,1,1,'','/admin/app/countrydiseaseprice/list',NULL,'108','richhtml',NULL,'','richhtml',NULL,'',22,85,86,1,'',0,0,0,0,NULL,NULL,NULL,NULL)");
            
        $this->addSql('CREATE TABLE city_price (id INT AUTO_INCREMENT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) NOT NULL, ordering INT NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_disease_price (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) NOT NULL, ordering INT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_price (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, text_type LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_raw LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, text_formatted LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) NOT NULL, ordering INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234C4663E4');
        $this->addSql('DROP INDEX IDX_2D5B0234C4663E4 ON city');
        $this->addSql('ALTER TABLE city CHANGE page_id city_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02348942858E FOREIGN KEY (city_price) REFERENCES city_price (id)');
        $this->addSql('CREATE INDEX IDX_2D5B02348942858E ON city (city_price)');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C966C4663E4');
        $this->addSql('DROP INDEX UNIQ_5373C966C4663E4 ON country');
        $this->addSql('ALTER TABLE country CHANGE page_id country_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C9666D283733 FOREIGN KEY (country_price) REFERENCES country_price (id)');
        $this->addSql('CREATE INDEX IDX_5373C9666D283733 ON country (country_price)');
        
        $this->addSql('ALTER TABLE country_disease DROP FOREIGN KEY FK_C67732ACC4663E4');
        $this->addSql('DROP INDEX UNIQ_C67732ACC4663E4 ON country_disease');
        $this->addSql('ALTER TABLE country_disease CHANGE page_id country_disease_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country_disease ADD CONSTRAINT FK_C67732AC960586E1 FOREIGN KEY (country_disease_price) REFERENCES country_disease_price (id)');
        $this->addSql('CREATE INDEX IDX_C67732AC960586E1 ON country_disease (country_disease_price)');
        
        $this->addSql('DROP TABLE page');
        
        $this->addSql('ALTER TABLE country_disease DROP FOREIGN KEY FK_C67732AC960586E1');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C9666D283733');
        $this->addSql('DROP TABLE country_disease_price');
        $this->addSql('DROP TABLE country_price');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02348942858E');
        $this->addSql('DROP INDEX IDX_2D5B02348942858E ON city');
        $this->addSql('ALTER TABLE city DROP city_price');
        $this->addSql('ALTER TABLE city_price ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city_price ADD CONSTRAINT FK_8942858E8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_8942858E8BAC62AF ON city_price (city_id)');
        $this->addSql('DROP INDEX IDX_5373C9666D283733 ON country');
        $this->addSql('ALTER TABLE country DROP country_price');
        $this->addSql('DROP INDEX IDX_C67732AC960586E1 ON country_disease');
        $this->addSql('ALTER TABLE country_disease DROP country_disease_price');
        
        $this->addSql('ALTER TABLE disease ADD favMain TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE med_direction DROP FOREIGN KEY FK_860B1AD8659429DB');
        $this->addSql('DROP INDEX IDX_860B1AD8659429DB ON med_direction');
        $this->addSql('ALTER TABLE med_direction DROP icon, DROP favourite_etc');
        
        $this->addSql('DROP TABLE last_request');
        
        $this->addSql('DROP TABLE promo_main');
        
        $this->addSql('ALTER TABLE country_disease ADD favourite TINYINT(1) NOT NULL');
        
        $this->addSql('ALTER TABLE disease DROP FOREIGN KEY FK_F3B6AC1733D5B5D');
        $this->addSql('DROP INDEX IDX_F3B6AC1733D5B5D ON disease');
        $this->addSql('ALTER TABLE disease DROP curator_id');
        
        $this->addSql('ALTER TABLE opinion DROP priority');
    
        $this->addSql('ALTER TABLE opinion CHANGE city_living city_living VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        
        $this->addSql('ALTER TABLE opinion CHANGE rating rating INT DEFAULT NULL');
        
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027C53D045F');
        $this->addSql('DROP INDEX IDX_AB02B027C53D045F ON opinion');
        $this->addSql('ALTER TABLE opinion DROP image, DROP rating_doctor, DROP rating_translator, DROP rating_services, DROP city_living, DROP sex, DROP answer_type, DROP answer_raw, DROP answer_formatted');
        
        $this->addSql('ALTER TABLE cost_example DROP FOREIGN KEY FK_288213A0C53D045F');
        $this->addSql('DROP INDEX IDX_288213A0C53D045F ON cost_example');
        $this->addSql('ALTER TABLE cost_example DROP image, DROP city');

        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234C53D045F');
        $this->addSql('DROP INDEX IDX_2D5B0234C53D045F ON city');
        $this->addSql('ALTER TABLE city DROP image');
        
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027D8355341');
        $this->addSql('DROP INDEX IDX_AB02B027D8355341 ON opinion');
        $this->addSql('ALTER TABLE opinion DROP disease_id');
        
        $this->addSql('ALTER TABLE disease DROP rating, DROP technologies');
    }
}
