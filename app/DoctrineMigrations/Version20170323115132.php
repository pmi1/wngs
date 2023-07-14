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
class Version20170323115132 extends AbstractMigration implements ContainerAwareInterface
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
             (69,'Манипуляции клиники',40,4,1,1,'','/admin/app/clinicmanipulation/list',NULL,'40/69','richhtml',NULL,'','richhtml',NULL,'',9,34,35,1,'',0,0,0,0),
             (70,'Группы атрибутов',5,3,1,1,'','/admin/app/clinicattrgroup/list',NULL,'70','richhtml',NULL,'','richhtml',NULL,'',15,63,64,1,'',0,0,0,0),
             (71,'Атрибуты клиники',5,3,1,1,'','/admin/app/clinicattr/list',NULL,'71','richhtml',NULL,'','richhtml',NULL,'',16,65,66,1,'',0,0,0,0),
             (72,'Параметры клиники',5,3,1,1,'','/admin/app/clinicparam/list',NULL,'72','richhtml',NULL,'','richhtml',NULL,'',17,67,68,1,'',0,0,0,0),
             (73,'Мультизначения параметров клиники',40,4,1,1,'','/admin/app/clinicparamval/list',NULL,'40/73','richhtml',NULL,'','richhtml',NULL,'',10,36,37,1,'',0,0,0,0)");
        
        $this->addSql('INSERT IGNORE INTO role_script(role_id, cmf_script_id) SELECT 1, id FROM cmf_script');

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

    }
}
