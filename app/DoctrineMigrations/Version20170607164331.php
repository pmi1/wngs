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
class Version20170607164331 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql('CREATE TABLE from_answer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, call_time VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, question LONGTEXT DEFAULT NULL, answer_file VARCHAR(255) DEFAULT NULL, answer_date DATETIME DEFAULT NULL, referer_link VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_form_answer (form_answer_id INT NOT NULL, clinic_id INT NOT NULL, INDEX IDX_AB35170CDB33F70B (form_answer_id), INDEX IDX_AB35170CCC22AD4 (clinic_id), PRIMARY KEY(form_answer_id, clinic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic_form_answer ADD CONSTRAINT FK_AB35170CDB33F70B FOREIGN KEY (form_answer_id) REFERENCES from_answer (id)');
        $this->addSql('ALTER TABLE clinic_form_answer ADD CONSTRAINT FK_AB35170CCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql("INSERT IGNORE INTO `cmf_script` (`id`,`name`,`parent_id`,`depth`,`status`,`real_status`,`article`,`url`,`catname`,`realcatname`,`preview_type`,`preview_raw`,`preview_formatted`,`text_type`,`text_raw`,`text_formatted`,`ordering`,`left_margin`,`right_margin`,`lastnode`,`modelname`,`is_group_node`,`is_new_win`,`is_exclude_path`,`is_search`,`meta_title`,`meta_description`,`meta_keywords`,`deleted_at`) VALUES 
            (110, 'Ответы на формы', 5, 3, 1, 1, '', '/admin/app/formanswer/list', NULL, '110', 'richhtml', NULL, '', 'richhtml', NULL, '', 24, 83, 84, 1, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL),
            (111, 'Спасибо!', 84, 3, 1, 1, '', NULL, 'thankyou', 'thankyou', 'richhtml', NULL, '', 'richhtml', '<p>Наши специалисты скоро свяжутся с вами.</p>', '<p>Наши специалисты скоро свяжутся с вами.</p>', 10, 123, 124, 1, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL)");
            
        $this->addSql('INSERT IGNORE INTO `role_script` (`role_id`,`cmf_script_id`) VALUES (1, 110), (2, 110)');
        $this->addSql('INSERT IGNORE INTO `role_script` (`role_id`,`cmf_script_id`) VALUES (1, 111), (2, 111)');
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

        $this->addSql('ALTER TABLE clinic_form_answer DROP FOREIGN KEY FK_AB35170CDB33F70B');
        $this->addSql('DROP TABLE from_answer');
        $this->addSql('DROP TABLE clinic_form_answer');
    }
}
