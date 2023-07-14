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
class Version20170316085326 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
         (63,'Похожие клиники',40,4,1,1,'','/admin/app/relatedclinic/list',NULL,'40/63','richhtml',NULL,'','richhtml',NULL,'',3,24,25,1,'',0,0,0,0),
         (64,'Группы атрибутов клиники',40,4,1,1,'','/admin/app/clinicattrgroup/list',NULL,'40/64','richhtml',NULL,'','richhtml',NULL,'',4,26,27,1,'',0,0,0,0)");
         
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`) VALUES 
             (65,'Атрибуты клиники',40,4,1,1,'','/admin/app/clinicattr/list',NULL,'40/65','richhtml',NULL,'','richhtml',NULL,'',5,28,29,1,'',0,0,0,0),
             (66,'Атрибуты клиники: списки',40,4,1,1,'','/admin/app/clinicattrlink/list',NULL,'40/66','richhtml',NULL,'','richhtml',NULL,'',6,30,31,1,'',0,0,0,0),
             (67,'Атрибуты клиники: значения',40,4,1,1,'','/admin/app/clinicattrval/list',NULL,'40/67','richhtml',NULL,'','richhtml',NULL,'',7,32,33,1,'',0,0,0,0),
             (68,'Заболевания клиники',40,4,1,1,'','/admin/app/clinicdisease/list',NULL,'40/68','richhtml',NULL,'','richhtml',NULL,'',8,34,35,1,'',0,0,0,0)");
        
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
    }
}
