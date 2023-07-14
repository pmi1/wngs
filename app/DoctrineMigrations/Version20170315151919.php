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
class Version20170315151919 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql('UPDATE user SET `status` = 1 WHERE user_id = 3');
        $this->addSql('INSERT IGNORE INTO user_role_group(user_id, roles_group_id) VALUES (3,1), (3,2), (3,3)');
        
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (34,'подстраница',29,3,1,1,'',NULL,'p111','test/p111','richhtml','asdfasdf','<p>asdfasdf</p>\n','richhtml','asdfasdf','<p>asdfasdf</p>\n',1,67,70,0,'',0,0,0,0),
         (35,'уровень 3',34,4,1,1,'',NULL,'333','test/p111/333','richhtml','фывафыа','<p>фывафыа</p>\n','richhtml','фывафыва32','<p>фывафыва32</p>\n',1,68,69,1,'',0,0,0,0)");
         
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (36,'Контакты',2,2,1,1,'',NULL,'contacts','contacts','richhtml','<p><u><strong>текст1<img alt=\"\" src=\"/uploads/media/default/0001/01/c7fa692e6fedb875a8883d21764b2715dc8d8772.png\" style=\"height:280px; width:280px\" /></strong></u></p>','<p><u><strong>текст1<img alt=\"\" src=\"/uploads/media/default/0001/01/c7fa692e6fedb875a8883d21764b2715dc8d8772.png\" style=\"height:280px; width:280px\" /></strong></u></p>','richhtml','<p>текст2</p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/media/default/0001/01/08ae6ac184a6f4dd1617f8020b5e0d372154365f.png\" style=\"height:280px; width:280px\" /></p>','<p>текст2</p>\n\n<p><img alt=\"\" src=\"/uploads/media/default/0001/01/08ae6ac184a6f4dd1617f8020b5e0d372154365f.png\" style=\"height:280px; width:280px\" /></p>',1,72,73,1,'',0,0,0,0),
         (39,'Города',5,3,1,1,'','/admin/app/city/list',NULL,'39','richhtml',NULL,'','richhtml',NULL,'',1,15,16,1,'',0,0,0,0)");
         
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (40,'Клиники',5,3,1,1,'','/admin/app/clinic/list',NULL,'40','richhtml',NULL,'','richhtml',NULL,'',1,17,22,0,'',0,0,0,0),
         (41,'Заболевания',5,3,1,1,'','/admin/app/disease/list',NULL,'41','richhtml',NULL,'','richhtml',NULL,'',4,25,26,1,'',0,0,0,0),
         (42,'Манипуляции',5,3,1,1,'','/admin/app/manipulation/list',NULL,'42','richhtml',NULL,'','richhtml',NULL,'',5,27,28,1,'',0,0,0,0),
         (43,'Направления медицины',5,3,1,1,'','/admin/app/meddirection/list',NULL,'43','richhtml',NULL,'','richhtml',NULL,'',6,29,30,1,'',0,0,0,0),
         (44,'Отзывы',5,3,1,1,'','/admin/app/opinion/list',NULL,'44','richhtml',NULL,'','richhtml',NULL,'',7,31,32,1,'',0,0,0,0),
         (46,'Справочники',1,2,1,1,'',NULL,NULL,'46','richhtml',NULL,'','richhtml',NULL,'',1,48,63,0,'',1,0,1,0)");
         
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (47,'Языковая поддержка',46,3,1,1,'','/admin/app/langsupport/list',NULL,'47','richhtml',NULL,'','richhtml',NULL,'',1,49,50,1,'',0,0,0,0),
         (48,'Кураторы',46,3,1,1,'','/admin/app/curator/list',NULL,'48','richhtml',NULL,'','richhtml',NULL,'',2,51,52,1,'',0,0,0,0),
         (49,'Ценовые сегменты',46,3,1,1,'','/admin/app/pricesegment/list',NULL,'49','richhtml',NULL,'','richhtml',NULL,'',3,53,54,1,'',0,0,0,0),
         (50,'Сертификаты',46,3,1,1,'','/admin/app/certificate/list',NULL,'50','richhtml',NULL,'','richhtml',NULL,'',4,55,56,1,'',0,0,0,0),
         (51,'Типы услуг клиники',46,3,1,1,'','/admin/app/serviceclinictype/list',NULL,'51','richhtml',NULL,'','richhtml',NULL,'',5,57,58,1,'',0,0,0,0),
         (52,'Специализации врачей',46,3,1,1,'','/admin/app/doctorspecialisation/list',NULL,'52','richhtml',NULL,'','richhtml',NULL,'',6,59,60,1,'',0,0,0,0)");
         
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (53,'Ученые степени врачей',46,3,1,1,'','/admin/app/doctordegree/list',NULL,'53','richhtml',NULL,'','richhtml',NULL,'',7,61,62,1,'',0,0,0,0),
         (54,'Страна-заболевание',5,3,1,1,'','/admin/app/countrydisease/list',NULL,'54','richhtml',NULL,'','richhtml',NULL,'',8,33,34,1,'',0,0,0,0),
         (55,'Город-Цена',5,3,1,1,'','/admin/app/cityprice/list',NULL,'55','richhtml',NULL,'','richhtml',NULL,'',9,35,36,1,'',0,0,0,0),
         (56,'Примеры затрат',5,3,1,1,'','/admin/app/costexample/list',NULL,'56','richhtml',NULL,'','richhtml',NULL,'',10,37,38,1,'',0,0,0,0),
         (57,'Врачи',5,3,1,1,'','/admin/app/doctor/list',NULL,'57','richhtml',NULL,'','richhtml',NULL,'',11,39,40,1,'',0,0,0,0),
         (58,'Акции',5,3,1,1,'','/admin/app/promo/list',NULL,'58','richhtml',NULL,'','richhtml',NULL,'',12,41,42,1,'',0,0,0,0)");
         
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (59,'Медиа библиотека',5,3,1,1,'','/admin/sonata/media/media/list',NULL,'59','richhtml',NULL,'','richhtml',NULL,'',13,43,44,1,'',0,0,0,0),
         (60,'Галерея',5,3,1,1,'','/admin/sonata/media/gallery/list',NULL,'60','richhtml',NULL,'','richhtml',NULL,'',14,45,46,1,'',0,0,0,0),
         (61,'Видео клиник',40,4,1,1,'','/admin/app/clinicvideo/list',NULL,'40/61','richhtml',NULL,'','richhtml',NULL,'',1,18,19,1,'',0,0,0,0),
         (62,'Изображения клиник',40,4,1,1,'','/admin/app/clinicimage/list',NULL,'40/62','richhtml',NULL,'','richhtml',NULL,'',2,20,21,1,'',0,0,0,0)");
        
        $this->addSql('INSERT IGNORE INTO role_script(role_id, cmf_script_id) SELECT 1, id FROM cmf_script');
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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE user SET `status` = 0 WHERE user_id = 3');
    }
}
