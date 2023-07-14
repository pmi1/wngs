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
class Version20170418084224 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql('ALTER TABLE med_direction ADD image INT DEFAULT NULL');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        
        $this->addSql('CREATE TABLE disease_image (disease_image_id INT AUTO_INCREMENT NOT NULL, disease_id INT DEFAULT NULL, image INT DEFAULT NULL, INDEX IDX_6A4572A3D8355341 (disease_id), INDEX IDX_6A4572A3C53D045F (image), PRIMARY KEY(disease_image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease_video (disease_video_id INT AUTO_INCREMENT NOT NULL, disease_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, html_code LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT DEFAULT NULL, INDEX IDX_D3BFACD0D8355341 (disease_id), PRIMARY KEY(disease_video_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disease_image ADD CONSTRAINT FK_6A4572A3D8355341 FOREIGN KEY (disease_id) REFERENCES disease (disease_id)');
        $this->addSql('ALTER TABLE disease_image ADD CONSTRAINT FK_6A4572A3C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE disease_video ADD CONSTRAINT FK_D3BFACD0D8355341 FOREIGN KEY (disease_id) REFERENCES disease (disease_id)');
        $this->addSql('ALTER TABLE disease ADD name_rd VARCHAR(255) DEFAULT NULL, ADD name_dt VARCHAR(255) DEFAULT NULL, ADD name_tv VARCHAR(255) DEFAULT NULL, ADD h1 VARCHAR(255) DEFAULT NULL, ADD action DOUBLE PRECISION DEFAULT NULL, ADD fav TINYINT(1) NOT NULL, ADD favMain TINYINT(1) NOT NULL');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
            (74, 'Видео заболеваний', 41, 4, 1, 1, '', '/admin/app/diseasevideo/list', NULL, '41/74', 'richhtml', NULL, '', 'richhtml', NULL, '', 1, 42, 43, 1, '', 0, 0, 0, 0),
            (75, 'Изображения заболеваний', 41, 4, 1, 1, '', '/admin/app/diseaseimage/list', NULL, '41/75', 'richhtml', NULL, '', 'richhtml', NULL, '', 2, 44, 45, 1, '', 0, 0, 0, 0)");
        
        $this->addSql('INSERT IGNORE INTO role_script(role_id, cmf_script_id) SELECT 1, id FROM cmf_script');
        
        $this->addSql('DROP INDEX link ON clinic');
        $this->addSql('ALTER TABLE clinic_attr DROP FOREIGN KEY FK_53FCF08DC53D045F');
        $this->addSql('DROP INDEX fk_53fcf08dc53d045f ON clinic_attr');
        $this->addSql('CREATE INDEX IDX_53FCF08DC53D045F ON clinic_attr (image)');
        $this->addSql('ALTER TABLE clinic_attr ADD CONSTRAINT FK_53FCF08DC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE med_direction DROP FOREIGN KEY FK_860B1AD8C53D045F');
        $this->addSql('ALTER TABLE med_direction ADD name_rd VARCHAR(255) DEFAULT NULL, ADD name_dt VARCHAR(255) DEFAULT NULL, ADD name_tv VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX fk_860b1ad8c53d045f ON med_direction');
        $this->addSql('CREATE INDEX IDX_860B1AD8C53D045F ON med_direction (image)');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027F92F3E70');
        $this->addSql('DROP INDEX fk_ab02b027f92f3e70 ON opinion');
        $this->addSql('CREATE INDEX IDX_AB02B027F92F3E70 ON opinion (country_id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        
        $this->addSql('CREATE TABLE disease_country (disease_id INT NOT NULL, country_id INT NOT NULL, enabled TINYINT(1) NOT NULL, favourite TINYINT(1) NOT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, PRIMARY KEY(disease_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    
        $this->addSql('ALTER TABLE med_direction ADD favourite TINYINT(1) NOT NULL');
        
        $this->addSql("INSERT INTO `user` (`user_id`, `name`, `login`, `password`, `status`, `plain_password`) VALUES
        (1, 'Не авторизованный пользователь', 'notathorized', 'ZeVIFm7k2L7qXgrtTnto7e0TnrFMwlLCbChP3Zk0YNQAuL', 1, '');");
        $this->addSql("INSERT INTO `role` (`role_id`, `name`, `status`) VALUES(4, 'Клиентская часть', 1);");
        $this->addSql("INSERT INTO `roles_group` (`roles_group_id`, `name`) VALUES(4, 'Клиентская часть');");
        $this->addSql("INSERT INTO `privilege` (`roles_group_id`, `role_id`, `is_read`, `is_write`, `is_insert`, `is_delete`) VALUES(4, 4, 1, 1, 1, 1);");
        $this->addSql("INSERT INTO `user_role_group` (`user_id`, `roles_group_id`) VALUES(1, 4);");
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`) VALUES
        (76, 'Главное меню', 2, 2, 1, 1, '', NULL, NULL, '76', 'richhtml', NULL, '', 'richhtml', NULL, '', 2, 98, 105, 0, '', 0, 0, 1, 0),
        (77, 'Первая клиника', 76, 3, 1, 1, '', '/hospital/first_clinic/', NULL, '77', 'richhtml', NULL, '', 'richhtml', NULL, '', 1, 99, 100, 1, '', 0, 0, 0, 0),
        (78, 'О компании', 76, 3, 1, 1, '', NULL, 'about', 'about', 'richhtml', '<p>xxx</p>', '<p>xxx</p>', 'richhtml', '<p>zzz</p>', '<p>zzz</p>', 1, 101, 102, 1, '', 0, 0, 0, 0),
        (79, 'Тест 1', 76, 3, 1, 1, '', NULL, 'test1', 'test1', 'richhtml', '<p>ccc</p>', '<p>ccc</p>', 'richhtml', '<p>vvv</p>', '<p>vvv</p>', 1, 103, 104, 1, '', 0, 0, 0, 0),
        (80, 'Нижнее меню', 2, 2, 1, 1, '', NULL, NULL, '80', 'richhtml', NULL, '', 'richhtml', NULL, '', 1, 90, 97, 0, '', 0, 0, 1, 0),
        (81, 'Тест2', 80, 3, 1, 1, '', NULL, 'test2', 'test2', 'richhtml', '<p>zxc</p>', '<p>zxc</p>', 'richhtml', '<p>ccc</p>', '<p>ccc</p>', 1, 91, 92, 1, '', 0, 0, 0, 0),
        (82, 'Тест 3', 80, 3, 1, 1, '', NULL, 'test3', 'test3', 'richhtml', '<p>zxc</p>', '<p>zxc</p>', 'richhtml', '<p>cvcv</p>', '<p>cvcv</p>', 2, 93, 94, 1, '', 0, 0, 0, 0),
        (83, 'О компании', 80, 3, 1, 1, '', '/about/', NULL, '78', 'richhtml', NULL, '', 'richhtml', NULL, '', 3, 95, 96, 1, '', 0, 0, 0, 0);");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
        (4, 76),
        (4, 77),
        (4, 78),
        (4, 79),
        (4, 80),
        (4, 81),
        (4, 82),
        (4, 83);");
        
        $this->addSql('INSERT IGNORE INTO role_script(role_id, cmf_script_id) SELECT 1, id FROM cmf_script');
        
        $this->addSql('ALTER TABLE country ADD flag INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966D1F4EB9A FOREIGN KEY (flag) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_5373C966D1F4EB9A ON country (flag)');        
        $this->addSql("DELETE FROM `role_script` WHERE `cmf_script_id` IN(2,29,34,35,36,76,77,78,79,80,81,82,83)");
        $this->addSql("DELETE FROM `cmf_script` WHERE `id` IN(2,29,34,35,36,76,77,78,79,80,81,82,83)");
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
             (2,'Клиентская часть',0,1,1,1,'','','','','',NULL,NULL,'',NULL,NULL,2,91,142,0,'',1,0,1,0),
             (76,'Главное меню',2,2,1,1,'',NULL,NULL,'76','richhtml',NULL,'','richhtml',NULL,'',2,110,125,0,'',0,0,1,0),
             (77,'О компании',76,3,1,1,'','/about/',NULL,'77','richhtml',NULL,'','richhtml',NULL,'',1,111,112,1,'',0,0,0,0),
             (78,'Клиники',76,3,1,1,'','/',NULL,'78','richhtml','<p>xxx</p>','<p>xxx</p>','richhtml','<p>zzz</p>','<p>zzz</p>',2,113,114,1,'',0,0,0,0);
            INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
             (79,'Страны',76,3,1,1,'','/country/',NULL,'79','richhtml','<p>ccc</p>','<p>ccc</p>','richhtml','<p>vvv</p>','<p>vvv</p>',3,115,116,1,'',0,0,0,0),
             (80,'Нижнее меню',2,2,1,1,'',NULL,NULL,'80','richhtml',NULL,'','richhtml',NULL,'',3,126,141,0,'',0,0,1,0),
             (81,'О компании',80,3,1,1,'','/about/',NULL,'81','richhtml','<p>zxc</p>','<p>zxc</p>','richhtml','<p>ccc</p>','<p>ccc</p>',1,127,128,1,'',0,0,0,0),
             (82,'Клиники',80,3,1,1,'','/',NULL,'82','richhtml','<p>zxc</p>','<p>zxc</p>','richhtml','<p>cvcv</p>','<p>cvcv</p>',2,129,130,1,'',0,0,0,0),
             (83,'Страны',80,3,1,1,'','/country/',NULL,'83','richhtml',NULL,'','richhtml',NULL,'',3,131,132,1,'',0,0,0,0),
             (84,'Главная',2,2,1,1,'mainClientPage','/',NULL,'84','richhtml',NULL,'','richhtml',NULL,'',1,92,109,0,'',0,0,1,0);
            INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
             (85,'О компании',84,3,1,1,'',NULL,'about','about','richhtml',NULL,'','richhtml',NULL,'',1,93,94,1,'',0,0,0,0),
             (86,'Клиники',84,3,1,1,'','/',NULL,'86','richhtml',NULL,'','richhtml',NULL,'',2,95,96,1,'',0,0,0,0),
             (87,'Страны',84,3,1,1,'countryIndex','/country/',NULL,'87','richhtml',NULL,'','richhtml',NULL,'',3,97,98,1,'',0,0,0,0),
             (88,'Заболевания',84,3,1,1,'diseaseIndex','/disease/',NULL,'88','richhtml',NULL,'','richhtml',NULL,'',4,99,100,1,'',0,0,0,0),
             (89,'Информация',84,3,1,1,'',NULL,'information','information','richhtml',NULL,'','richhtml',NULL,'',5,101,102,1,'',0,0,0,0),
             (90,'Отзывы',84,3,1,1,'opinionIndex',NULL,'opinion','opinion','richhtml',NULL,'','richhtml',NULL,'',6,103,104,1,'',0,0,0,0),
             (91,'Контакты',84,3,1,1,'',NULL,'contacts','contacts','richhtml',NULL,'','richhtml',NULL,'',7,105,106,1,'',0,0,0,0);
            INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
             (92,'Поиск',84,3,1,1,'searchIndex','/search/',NULL,'92','richhtml',NULL,'','richhtml',NULL,'',8,107,108,1,'',0,0,0,0),
             (93,'Заболевания',76,3,1,1,'','/disease/',NULL,'93','richhtml',NULL,'','richhtml',NULL,'',4,117,118,1,'',0,0,0,0),
             (94,'Информация',76,3,1,1,'','/information/',NULL,'94','richhtml',NULL,'','richhtml',NULL,'',5,119,120,1,'',0,0,0,0),
             (95,'Отзывы',76,3,1,1,'','/opinion/',NULL,'95','richhtml',NULL,'','richhtml',NULL,'',6,121,122,1,'',0,0,0,0),
             (96,'Контакты',76,3,1,1,'','/contacts/',NULL,'96','richhtml',NULL,'','richhtml',NULL,'',7,123,124,1,'',0,0,0,0),
             (97,'Заболевания',80,3,1,1,'','/disease/',NULL,'97','richhtml',NULL,'','richhtml',NULL,'',4,133,134,1,'',0,0,0,0),
             (98,'Информация',80,3,1,1,'','/information/',NULL,'98','richhtml',NULL,'','richhtml',NULL,'',5,135,136,1,'',0,0,0,0);
            INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
             (99,'Отзывы',80,3,1,1,'','/opinion/',NULL,'99','richhtml',NULL,'','richhtml',NULL,'',6,137,138,1,'',0,0,0,0),
             (100,'Контакты',80,3,1,1,'','/contacts/',NULL,'100','richhtml',NULL,'','richhtml',NULL,'',7,139,140,1,'',0,0,0,0)");
         
        $this->addSql("INSERT IGNORE INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
            (4, 76),
            (4, 77),
            (4, 78),
            (4, 79),
            (4, 80),
            (4, 81),
            (4, 82),
            (4, 83),
            (4, 84),
            (4, 85),
            (4, 86),
            (4, 87),
            (4, 88),
            (4, 89),
            (4, 90),
            (4, 91),
            (4, 92),
            (4, 93),
            (4, 94),
            (4, 95),
            (4, 96),
            (4, 97),
            (4, 98),
            (4, 99),
            (4, 100)
        ");
        
        
        $this->addSql('ALTER TABLE med_direction ADD h1 VARCHAR(255) DEFAULT NULL');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`) VALUES
        (101, 'Направление медицины', 84, 3, 1, 1, 'medDirection', '/', NULL, '101', 'richhtml', NULL, '', 'richhtml', NULL, '', 9, 109, 110, 1, '', 0, 0, 0, 0)");
        $this->addSql("INSERT IGNORE INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
            (4, 101)
        ");
        
        $this->addSql('ALTER TABLE clinic ADD rating NUMERIC(4, 2) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE cmf_script ADD meta_title VARCHAR(255) DEFAULT NULL, ADD meta_description LONGTEXT DEFAULT NULL, ADD meta_keywords LONGTEXT DEFAULT NULL');
        
        $this->addSql('ALTER TABLE clinic_med_direction ADD favourite TINYINT(1) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE med_direction CHANGE favourite favourite TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE `med_direction` CHANGE COLUMN `med_direction_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `country_disease` CHANGE COLUMN `certificate_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `cost_example` CHANGE COLUMN `cost_example_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `disease` CHANGE COLUMN `disease_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `manipulation` CHANGE COLUMN `manipulation_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `disease_image` CHANGE COLUMN `disease_image_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `disease_video` CHANGE COLUMN `disease_video_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `doctor` CHANGE COLUMN `doctor_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `opinion` CHANGE COLUMN `opinion_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `promo` CHANGE COLUMN `promo_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `certificate` CHANGE COLUMN `certificate_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `city` CHANGE COLUMN `city_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `city_price` CHANGE COLUMN `certificate_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic` CHANGE COLUMN `clinic_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_attr` CHANGE COLUMN `clinic_attr_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_attr_group` CHANGE COLUMN `clinic_attr_group_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_attr_val` CHANGE COLUMN `clinic_attr_val_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_image` CHANGE COLUMN `clinic_image_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_manipulation` CHANGE COLUMN `clinic_manipulation_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_param` CHANGE COLUMN `clinic_param_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_param_val` CHANGE COLUMN `clinic_param_val_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `clinic_video` CHANGE COLUMN `clinic_video_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `curator` CHANGE COLUMN `curator_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `doctor_degree` CHANGE COLUMN `doctor_degree_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `doctor_specialisation` CHANGE COLUMN `doctor_specialisation_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `lang_support` CHANGE COLUMN `lang_support_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `price_segment` CHANGE COLUMN `price_segment_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `related_clinic` CHANGE COLUMN `related_clinic_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `role` CHANGE COLUMN `role_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `roles_group` CHANGE COLUMN `roles_group_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `service_clinic_type` CHANGE COLUMN `service_clinic_type_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        $this->addSql('ALTER TABLE `user` CHANGE COLUMN `user_id` `id` INTEGER NOT NULL AUTO_INCREMENT');
        
        
        $this->addSql('ALTER TABLE certificate ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE city_price ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_attr ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_attr_group ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_attr_link ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_attr_val ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_disease ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_image ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_manipulation ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_med_direction ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_param ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_param_link ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_param_val ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic_video ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE cmf_script ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE cost_example ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE country_disease ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE curator ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE disease ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE disease_country ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE disease_image ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE disease_video ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor_degree ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor_specialisation ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE lang_support ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE manipulation ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE med_direction ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE opinion ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE price_segment ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE related_clinic ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE role ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE roles_group ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service_clinic_type ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD deleted_at DATETIME DEFAULT NULL');
        
        $this->addSql('CREATE TABLE country_article (id INT AUTO_INCREMENT NOT NULL, country_name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country_article ADD CONSTRAINT FK_CB76560BBF396750 FOREIGN KEY (id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country ADD h1 VARCHAR(255) DEFAULT NULL');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
            (102,	'Статьи',	31,	4,	1,	1,	'',	'/admin/app/countryarticle/list',	NULL,	'31/102',	'richhtml',	NULL,	'',	'richhtml',	NULL,	'',	1,	40,	41,	1,	'',	0,	0,	0,	0,	NULL,	NULL,	NULL)");
        $this->addSql('INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (1,	102),(2,	102)');
        
        $this->addSql('ALTER TABLE country_article DROP FOREIGN KEY FK_CB76560BBF396750');
        $this->addSql('ALTER TABLE country_article ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country_article ADD CONSTRAINT FK_CB76560BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_CB76560BF92F3E70 ON country_article (country_id)');
        
        $this->addSql('CREATE TABLE country_med_direction (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, med_direction_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, h1 VARCHAR(255) DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, ordering INT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_75BEC81CF92F3E70 (country_id), INDEX IDX_75BEC81CC224826D (med_direction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country_med_direction ADD CONSTRAINT FK_75BEC81CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country_med_direction ADD CONSTRAINT FK_75BEC81CC224826D FOREIGN KEY (med_direction_id) REFERENCES med_direction (id)');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
            (103,	'Страна-направление',	5,	3,	1,	1,	'countryMedDirectionIndex',	'/admin/app/countrymeddirection/list',	NULL,	'103',	'richhtml',	NULL,	'',	'richhtml',	NULL,	'',	5,	49,	50,	1,	'',	0,	0,	0,	0,	NULL,	NULL,	NULL,	NULL);");
        $this->addSql('INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (1,	103),(2,	103)');
        
        $this->addSql('ALTER TABLE disease CHANGE fav fav TINYINT(1) DEFAULT NULL, CHANGE favMain favMain TINYINT(1) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE clinic ADD images INT DEFAULT NULL, ADD videos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4E01FBE6A FOREIGN KEY (images) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B429AA6432 FOREIGN KEY (videos) REFERENCES media__gallery (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_783F8B4E01FBE6A ON clinic (images)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_783F8B429AA6432 ON clinic (videos)');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(104, 'Элементы галереи', 60, 4, 1, 1, '', '/admin/sonata/media/galleryhasmedia/list', NULL, '60/104', 'richhtml', NULL, '', 'richhtml', NULL, '', 1, 70, 71, 1, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL)");
        $this->addSql("INSERT IGNORE INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
            (1, 104)
        ");
        
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B429AA6432');
        $this->addSql('DROP INDEX UNIQ_783F8B429AA6432 ON clinic');
        $this->addSql('ALTER TABLE clinic DROP videos');
        
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B4E01FBE6A');
        $this->addSql('DROP INDEX UNIQ_783F8B4E01FBE6A ON clinic');
        $this->addSql('ALTER TABLE clinic CHANGE images gallery INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4472B783A FOREIGN KEY (gallery) REFERENCES media__gallery (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_783F8B4472B783A ON clinic (gallery)');
        
        $this->addSql('DROP TABLE clinic_image');
        $this->addSql('DROP TABLE clinic_video');
        $this->addSql('DROP TABLE disease_image');
        $this->addSql('DROP TABLE disease_video');
        $this->addSql('ALTER TABLE disease ADD gallery INT DEFAULT NULL');
        $this->addSql('ALTER TABLE disease ADD CONSTRAINT FK_F3B6AC1472B783A FOREIGN KEY (gallery) REFERENCES media__gallery (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3B6AC1472B783A ON disease (gallery)');
        
        $this->addSql("ALTER TABLE `media__gallery_media` ADD COLUMN `main` TINYINT(1) NOT NULL AFTER `enabled`");
        
        $this->addSql('ALTER TABLE cost_example ADD disease_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cost_example ADD CONSTRAINT FK_288213A0D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('CREATE INDEX IDX_288213A0D8355341 ON cost_example (disease_id)');
        
        $this->addSql('CREATE TABLE compare (user_token CHAR(50) NOT NULL, clinic_id INT DEFAULT NULL, INDEX IDX_BDC9085DCC22AD4 (clinic_id), PRIMARY KEY(user_token)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compare ADD CONSTRAINT FK_BDC9085DCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        
        $this->addSql('ALTER TABLE clinic ADD advantage LONGTEXT DEFAULT NULL');
        
        $this->addSql('ALTER TABLE clinic ADD name_eng VARCHAR(255) DEFAULT NULL, ADD name_rd VARCHAR(255) DEFAULT NULL, ADD name_dt VARCHAR(255) DEFAULT NULL, ADD name_tv VARCHAR(255) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE city ADD name_rd VARCHAR(255) NOT NULL, ADD name_dt VARCHAR(255) NOT NULL, ADD name_tv VARCHAR(255) NOT NULL, ADD h1 VARCHAR(255) DEFAULT NULL, ADD airport_distance INT DEFAULT NULL');
        
        $this->addSql('ALTER TABLE city ADD name_pr VARCHAR(255) NOT NULL');
             
        $this->addSql('ALTER TABLE city CHANGE name_rd name_rd VARCHAR(255) DEFAULT NULL, CHANGE name_dt name_dt VARCHAR(255) DEFAULT NULL, CHANGE name_tv name_tv VARCHAR(255) DEFAULT NULL, CHANGE name_pr name_pr VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE country CHANGE country_name_rd country_name_rd VARCHAR(255) DEFAULT NULL, CHANGE country_name_dt country_name_dt VARCHAR(255) DEFAULT NULL, CHANGE country_name_tv country_name_tv VARCHAR(255) DEFAULT NULL, CHANGE country_name_pr country_name_pr VARCHAR(255) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE country ADD name_rd VARCHAR(255) DEFAULT NULL, ADD name_dt VARCHAR(255) DEFAULT NULL, ADD name_tv VARCHAR(255) DEFAULT NULL, ADD name_pr VARCHAR(255) DEFAULT NULL, DROP country_name_rd, DROP country_name_dt, DROP country_name_tv, DROP country_name_pr, CHANGE country_name name VARCHAR(255) NOT NULL');
        
        
        
    }   
    
    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $tokenStorage = $this->container->get('security.token_storage');
        $entityManager = $this->container->get('doctrine')->getEntityManager();
        $entityManager->getFilters()->disable('softdeleteable');

        $SecurityGeneratorListener = new SecurityGeneratorListener($tokenStorage, $entityManager);

        $repo = $entityManager->getRepository(CmfScript::class);
        $repo->RebuildTreeOrdering();
        $entityManager->getFilters()->enable('softdeleteable');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country ADD country_name_rd VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD country_name_dt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD country_name_tv VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD country_name_pr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP name_rd, DROP name_dt, DROP name_tv, DROP name_pr, CHANGE name country_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    
        $this->addSql('ALTER TABLE city CHANGE name_rd name_rd VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE name_dt name_dt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE name_tv name_tv VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE name_pr name_pr VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE country CHANGE country_name_rd country_name_rd VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE country_name_dt country_name_dt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE country_name_tv country_name_tv VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE country_name_pr country_name_pr VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    
        $this->addSql('ALTER TABLE city DROP name_pr');
        
        $this->addSql('ALTER TABLE city DROP name_rd, DROP name_dt, DROP name_tv, DROP h1, DROP airport_distance');
        
        $this->addSql('ALTER TABLE clinic DROP name_eng, DROP name_rd, DROP name_dt, DROP name_tv');
        
        $this->addSql('ALTER TABLE clinic DROP advantage');

        $this->addSql('DROP TABLE compare');
        
        $this->addSql('ALTER TABLE cost_example DROP FOREIGN KEY FK_288213A0D8355341');
        $this->addSql('DROP INDEX IDX_288213A0D8355341 ON cost_example');
        $this->addSql('ALTER TABLE cost_example DROP disease_id');
        
        $this->addSql('ALTER TABLE `media__gallery_media` DROP COLUMN `main`');
        
        $this->addSql('CREATE TABLE clinic_image (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, clinic_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_4CB9AD6CCC22AD4 (clinic_id), INDEX IDX_4CB9AD6CC53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_video (id INT AUTO_INCREMENT NOT NULL, clinic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, html_code LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F543731FCC22AD4 (clinic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease_image (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, disease_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_6A4572A3D8355341 (disease_id), INDEX IDX_6A4572A3C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disease_video (id INT AUTO_INCREMENT NOT NULL, disease_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, html_code LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status TINYINT(1) NOT NULL, ordering INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D3BFACD0D8355341 (disease_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic_image ADD CONSTRAINT FK_4CB9AD6CC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE clinic_image ADD CONSTRAINT FK_4CB9AD6CCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE clinic_video ADD CONSTRAINT FK_F543731FCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE disease_image ADD CONSTRAINT FK_6A4572A3C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE disease_image ADD CONSTRAINT FK_6A4572A3D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE disease_video ADD CONSTRAINT FK_D3BFACD0D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id)');
        $this->addSql('ALTER TABLE disease DROP FOREIGN KEY FK_F3B6AC1472B783A');
        $this->addSql('DROP INDEX UNIQ_F3B6AC1472B783A ON disease');
        $this->addSql('ALTER TABLE disease DROP gallery');
        
        
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B4472B783A');
        $this->addSql('DROP INDEX UNIQ_783F8B4472B783A ON clinic');
        $this->addSql('ALTER TABLE clinic CHANGE gallery images INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4E01FBE6A FOREIGN KEY (images) REFERENCES media__gallery (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_783F8B4E01FBE6A ON clinic (images)');
        
        
        $this->addSql('ALTER TABLE clinic ADD videos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B429AA6432 FOREIGN KEY (videos) REFERENCES media__gallery (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_783F8B429AA6432 ON clinic (videos)');
        
        
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B4E01FBE6A');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B429AA6432');
        $this->addSql('DROP INDEX UNIQ_783F8B4E01FBE6A ON clinic');
        $this->addSql('DROP INDEX UNIQ_783F8B429AA6432 ON clinic');
        $this->addSql('ALTER TABLE clinic DROP images, DROP videos');
        
        
        $this->addSql('ALTER TABLE disease CHANGE fav fav TINYINT(1) NOT NULL, CHANGE favMain favMain TINYINT(1) NOT NULL');
        
        $this->addSql('DROP TABLE country_med_direction');
        $this->addSql('DELETE FROM role_script WHERE cmf_script_id = 103');
        $this->addSql('DELETE FROM cmf_script WHERE id = 103');
        
        
        $this->addSql('ALTER TABLE country_article DROP FOREIGN KEY FK_CB76560BF92F3E70');
        $this->addSql('DROP INDEX IDX_CB76560BF92F3E70 ON country_article');
        $this->addSql('ALTER TABLE country_article DROP country_id');
        $this->addSql('ALTER TABLE country_article ADD CONSTRAINT FK_CB76560BBF396750 FOREIGN KEY (id) REFERENCES country (id)');
        
        $this->addSql('DROP TABLE country_article');
        $this->addSql('ALTER TABLE country DROP h1');
        $this->addSql('DELETE FROM role_script WHERE cmf_script_id = 102');
        $this->addSql('DELETE FROM cmf_script WHERE id = 102');
        
        $this->addSql('ALTER TABLE certificate DROP deleted_at');
        $this->addSql('ALTER TABLE city DROP deleted_at');
        $this->addSql('ALTER TABLE city_price DROP deleted_at');
        $this->addSql('ALTER TABLE clinic DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_attr DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_attr_group DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_attr_link DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_attr_val DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_disease DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_image DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_manipulation DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_med_direction DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_param DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_param_link DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_param_val DROP deleted_at');
        $this->addSql('ALTER TABLE clinic_video DROP deleted_at');
        $this->addSql('ALTER TABLE cmf_script DROP deleted_at');
        $this->addSql('ALTER TABLE cost_example DROP deleted_at');
        $this->addSql('ALTER TABLE country DROP deleted_at');
        $this->addSql('ALTER TABLE country_disease DROP deleted_at');
        $this->addSql('ALTER TABLE curator DROP deleted_at');
        $this->addSql('ALTER TABLE disease DROP deleted_at');
        $this->addSql('ALTER TABLE disease_country DROP deleted_at');
        $this->addSql('ALTER TABLE disease_image DROP deleted_at');
        $this->addSql('ALTER TABLE disease_video DROP deleted_at');
        $this->addSql('ALTER TABLE doctor DROP deleted_at');
        $this->addSql('ALTER TABLE doctor_degree DROP deleted_at');
        $this->addSql('ALTER TABLE doctor_specialisation DROP deleted_at');
        $this->addSql('ALTER TABLE lang_support DROP deleted_at');
        $this->addSql('ALTER TABLE manipulation DROP deleted_at');
        $this->addSql('ALTER TABLE med_direction DROP deleted_at');
        $this->addSql('ALTER TABLE opinion DROP deleted_at');
        $this->addSql('ALTER TABLE price_segment DROP deleted_at');
        $this->addSql('ALTER TABLE promo DROP deleted_at');
        $this->addSql('ALTER TABLE related_clinic DROP deleted_at');
        $this->addSql('ALTER TABLE role DROP deleted_at');
        $this->addSql('ALTER TABLE roles_group DROP deleted_at');
        $this->addSql('ALTER TABLE service_clinic_type DROP deleted_at');
        $this->addSql('ALTER TABLE user DROP deleted_at');
        
        
        $this->addSql('ALTER TABLE med_direction CHANGE favourite favourite TINYINT(1) NOT NULL');
        
        $this->addSql('ALTER TABLE clinic_med_direction DROP favourite');
        
        $this->addSql('ALTER TABLE cmf_script DROP meta_title, DROP meta_description, DROP meta_keywords');
        
        $this->addSql('ALTER TABLE clinic DROP rating');
        
        $this->addSql('ALTER TABLE med_direction DROP h1');
        
        
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C966D1F4EB9A');
        $this->addSql('DROP INDEX IDX_5373C966D1F4EB9A ON country');
        $this->addSql('ALTER TABLE country DROP flag');
        
        $this->addSql('ALTER TABLE med_direction DROP favourite');
        
        $this->addSql('DROP TABLE disease_country');
        
        $this->addSql('CREATE INDEX link ON clinic (link)');
        $this->addSql('ALTER TABLE clinic_attr DROP FOREIGN KEY FK_53FCF08DC53D045F');
        $this->addSql('DROP INDEX idx_53fcf08dc53d045f ON clinic_attr');
        $this->addSql('CREATE INDEX FK_53FCF08DC53D045F ON clinic_attr (image)');
        $this->addSql('ALTER TABLE clinic_attr ADD CONSTRAINT FK_53FCF08DC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE med_direction DROP FOREIGN KEY FK_860B1AD8C53D045F');
        $this->addSql('ALTER TABLE med_direction DROP name_rd, DROP name_dt, DROP name_tv');
        $this->addSql('DROP INDEX idx_860b1ad8c53d045f ON med_direction');
        $this->addSql('CREATE INDEX FK_860B1AD8C53D045F ON med_direction (image)');
        $this->addSql('ALTER TABLE med_direction ADD CONSTRAINT FK_860B1AD8C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027F92F3E70');
        $this->addSql('DROP INDEX idx_ab02b027f92f3e70 ON opinion');
        $this->addSql('CREATE INDEX FK_AB02B027F92F3E70 ON opinion (country_id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');        
        
        $this->addSql('DROP TABLE disease_image');
        $this->addSql('DROP TABLE disease_video');
        $this->addSql('ALTER TABLE disease DROP name_rd, DROP name_dt, DROP name_tv, DROP h1, DROP action, DROP fav, DROP favMain');
        
        $this->addSql('CREATE INDEX link ON clinic (link)');
        $this->addSql('ALTER TABLE clinic_attr DROP FOREIGN KEY FK_53FCF08DC53D045F');
        $this->addSql('DROP INDEX idx_53fcf08dc53d045f ON clinic_attr');
        $this->addSql('CREATE INDEX FK_53FCF08DC53D045F ON clinic_attr (image)');
        $this->addSql('ALTER TABLE clinic_attr ADD CONSTRAINT FK_53FCF08DC53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE med_direction DROP FOREIGN KEY FK_860B1AD8C53D045F');
        $this->addSql('DROP INDEX IDX_860B1AD8C53D045F ON med_direction');
        $this->addSql('ALTER TABLE med_direction DROP image');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027F92F3E70');
        $this->addSql('DROP INDEX idx_ab02b027f92f3e70 ON opinion');
        $this->addSql('CREATE INDEX FK_AB02B027F92F3E70 ON opinion (country_id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }
}
