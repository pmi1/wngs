<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\CmfScript;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161122180651 extends AbstractMigration implements ContainerAwareInterface
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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cmf_configure (user_id INT NOT NULL, script_name VARCHAR(255) NOT NULL, field_name VARCHAR(255) NOT NULL, ordering INT DEFAULT 0, is_visuality TINYINT(1) DEFAULT \'0\', PRIMARY KEY(user_id, script_name, field_name)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cmf_rights (cmf_role_group_combination_id CHAR(41) NOT NULL, script_id INT NOT NULL, is_read TINYINT(1) DEFAULT \'0\', is_write TINYINT(1) DEFAULT \'0\', is_insert TINYINT(1) DEFAULT \'0\', is_delete TINYINT(1) DEFAULT \'0\', INDEX IDX_7CDF134A1C01850 (script_id), PRIMARY KEY(cmf_role_group_combination_id, script_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cmf_script (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, parent_id INT NOT NULL, depth INT NOT NULL, status TINYINT(1) DEFAULT NULL, real_status TINYINT(1) DEFAULT NULL, article VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, catname VARCHAR(255) DEFAULT NULL, realcatname VARCHAR(255) DEFAULT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT NOT NULL, left_margin INT NOT NULL, right_margin INT NOT NULL, lastnode TINYINT(1) DEFAULT NULL, modelname VARCHAR(255) DEFAULT NULL, is_group_node TINYINT(1) DEFAULT NULL, is_new_win TINYINT(1) DEFAULT NULL, is_exclude_path TINYINT(1) DEFAULT NULL, is_search TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, country_name VARCHAR(255) NOT NULL, preview_type LONGTEXT DEFAULT NULL, preview_raw LONGTEXT DEFAULT NULL, preview_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, ordering INT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE privilege (roles_group_id INT NOT NULL, role_id INT NOT NULL, is_read TINYINT(1) NOT NULL, is_write TINYINT(1) NOT NULL, is_insert TINYINT(1) NOT NULL, is_delete TINYINT(1) NOT NULL, INDEX IDX_87209A87D401ACA5 (roles_group_id), INDEX IDX_87209A87D60322AC (role_id), PRIMARY KEY(roles_group_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (role_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_script (role_id INT NOT NULL, cmf_script_id INT NOT NULL, INDEX IDX_B7A7668BD60322AC (role_id), INDEX IDX_B7A7668BBD0710B4 (cmf_script_id), PRIMARY KEY(role_id, cmf_script_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_group (roles_group_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(roles_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role_group (user_id INT NOT NULL, roles_group_id INT NOT NULL, INDEX IDX_3D7B6A06A76ED395 (user_id), INDEX IDX_3D7B6A06D401ACA5 (roles_group_id), PRIMARY KEY(user_id, roles_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cmf_rights ADD CONSTRAINT FK_7CDF134A1C01850 FOREIGN KEY (script_id) REFERENCES cmf_script (id)');
        $this->addSql('ALTER TABLE privilege ADD CONSTRAINT FK_87209A87D401ACA5 FOREIGN KEY (roles_group_id) REFERENCES roles_group (roles_group_id)');
        $this->addSql('ALTER TABLE privilege ADD CONSTRAINT FK_87209A87D60322AC FOREIGN KEY (role_id) REFERENCES role (role_id)');
        $this->addSql('ALTER TABLE role_script ADD CONSTRAINT FK_B7A7668BD60322AC FOREIGN KEY (role_id) REFERENCES role (role_id)');
        $this->addSql('ALTER TABLE role_script ADD CONSTRAINT FK_B7A7668BBD0710B4 FOREIGN KEY (cmf_script_id) REFERENCES cmf_script (id)');
        $this->addSql('ALTER TABLE user_role_group ADD CONSTRAINT FK_3D7B6A06A76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE user_role_group ADD CONSTRAINT FK_3D7B6A06D401ACA5 FOREIGN KEY (roles_group_id) REFERENCES roles_group (roles_group_id)');

        $this->addSql("INSERT INTO `cmf_script` (`id`,`name`,`parent_id`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`text_type`,`ordering`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`depth`,`left_margin`,`right_margin`,`preview_raw`,`preview_formatted`,`text_raw`,`text_formatted`) VALUES 
             (1,'Административная часть',0,1,1,'',NULL,NULL,'1',NULL,NULL,1,0,'',1,0,1,0,1,1,18,NULL,NULL,NULL,NULL),
             (2,'Клиентская часть',0,1,1,'','','','','','',2,0,'',1,0,1,0,1,19,22,NULL,NULL,NULL,NULL),
             (4,'Администрирование',1,1,1,'',NULL,NULL,'4','richhtml','richhtml',1,0,'',1,0,1,0,2,2,11,NULL,'\n',NULL,'\n'),
             (5,'Контент',1,1,1,'',NULL,NULL,'5','richhtml','richhtml',1,0,'',1,0,1,0,2,12,17,NULL,'\n',NULL,'\n'),
             (16,'Структура сайта',4,1,1,'','/admin/cmfscript/list',NULL,'16','richhtml','richhtml',1,1,'',0,0,0,0,3,3,4,NULL,'\n',NULL,'\n'),
             (27,'Страницы сайта',5,1,1,'','/admin/script/list',NULL,'27','richhtml','richhtml',1,1,'',0,0,0,0,3,13,14,NULL,'\n',NULL,'\n'),
             (29,'Тестовый заголовок',2,1,1,'',NULL,'test','test','richhtml','richhtml',1,1,'',0,0,0,0,2,20,21,NULL,'\n','<p>Тут тестовый текст.1111</p>','<p>Тут тестовый текст.1111</p>\n')");
        $this->addSql("INSERT INTO `cmf_script` (`id`,`name`,`parent_id`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`text_type`,`ordering`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`depth`,`left_margin`,`right_margin`,`preview_raw`,`preview_formatted`,`text_raw`,`text_formatted`) VALUES 
             (30,'Пользователи',4,1,1,'','/admin/app/user/list',NULL,'30','richhtml','richhtml',2,1,'',0,0,0,0,3,5,6,NULL,'\n',NULL,'\n'),
             (31,'Страны',5,1,1,'','/admin/app/country/list',NULL,'31','richhtml','richhtml',2,1,'',0,0,0,0,3,15,16,NULL,'\n',NULL,'\n'),
             (32,'Модули',4,1,1,'','/admin/app/role/list',NULL,'32','richhtml','richhtml',3,1,'',0,0,0,0,3,7,8,NULL,'\n',NULL,'\n'),
             (33,'Роли',4,1,1,'','/admin/app/rolegroup/list',NULL,'33','richhtml','richhtml',4,1,'',0,0,0,0,3,9,10,NULL,'\n',NULL,'\n')");

        $this->addSql("INSERT INTO `cmf_rights` (`cmf_role_group_combination_id`,`script_id`,`is_read`,`is_write`,`is_insert`,`is_delete`) VALUES 
             ('1',4,1,0,0,0),
             ('1',5,1,0,0,0),
             ('1',16,1,0,0,0),
             ('1',27,1,0,0,0),
             ('1',30,1,0,0,0),
             ('1',31,1,0,0,0),
             ('1',32,1,0,0,0),
             ('1',33,1,0,0,0)");

        $this->addSql("INSERT INTO `roles_group` (`roles_group_id`,`name`) VALUES 
             (1,'Разработчик'),
             (2,'Администратор'),
             (3,'Редактор')");

        $this->addSql("INSERT INTO `role` (`role_id`,`name`,`status`) VALUES 
             (1,'Разделы для разработчика',1),
             (2,'Разделы для редактора',1)");

        $this->addSql('INSERT INTO `privilege` (`roles_group_id`,`role_id`,`is_read`,`is_write`,`is_insert`,`is_delete`) VALUES 
             (1,1,1,1,1,1),
             (1,2,1,1,1,1),
             (2,1,1,0,0,0),
             (2,2,0,1,0,0)');

        $this->addSql('INSERT INTO `role_script` (`role_id`,`cmf_script_id`) VALUES 
             (1,1),
             (1,2),
             (1,4),
             (1,5),
             (1,16),
             (1,27),
             (1,29),
             (1,30),
             (1,31),
             (1,32),
             (1,33),
             (2,5),
             (2,27),
             (2,31)');

        $this->addSql("INSERT INTO `user` (`user_id`,`name`,`password`,`status`,`login`) VALUES 
             (2,'Test1','',1,'vernal_u2'),
             (3,'Zzz','3P5q9S1q',0,'vernal_u')");

        $this->addSql('INSERT INTO `user_role_group` (`user_id`,`roles_group_id`) VALUES 
             (2,1),
             (2,2),
             (3,1),
             (3,2)');
    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $entityManager = $this->container->get('doctrine')->getEntityManager();
        $entityManager->getFilters()->disable('softdeleteable');
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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cmf_rights DROP FOREIGN KEY FK_7CDF134A1C01850');
        $this->addSql('ALTER TABLE role_script DROP FOREIGN KEY FK_B7A7668BBD0710B4');
        $this->addSql('ALTER TABLE privilege DROP FOREIGN KEY FK_87209A87D60322AC');
        $this->addSql('ALTER TABLE role_script DROP FOREIGN KEY FK_B7A7668BD60322AC');
        $this->addSql('ALTER TABLE privilege DROP FOREIGN KEY FK_87209A87D401ACA5');
        $this->addSql('ALTER TABLE user_role_group DROP FOREIGN KEY FK_3D7B6A06D401ACA5');
        $this->addSql('ALTER TABLE user_role_group DROP FOREIGN KEY FK_3D7B6A06A76ED395');
        $this->addSql('DROP TABLE cmf_configure');
        $this->addSql('DROP TABLE cmf_rights');
        $this->addSql('DROP TABLE cmf_script');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE privilege');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_script');
        $this->addSql('DROP TABLE roles_group');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role_group');
    }
}
