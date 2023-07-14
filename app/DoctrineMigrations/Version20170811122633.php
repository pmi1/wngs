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
class Version20170811122633 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql('CREATE TABLE city_article (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_BF72B0348BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city_article ADD CONSTRAINT FK_BF72B0348BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(115,   'Статьи',   39, 4,  1,  1,  NULL,   '/admin/app/cityarticle/list',  NULL,   '39/115',   'richhtml', NULL,   '', 'richhtml', NULL,   '', 1,  16, 17, 1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL);");
        $this->addSql('INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (1,    115),(2,    115)');
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

        $this->addSql('DROP TABLE city_article');
        $this->addSql('DELETE FROM role_script WHERE cmf_script_id = 115');
        $this->addSql('DELETE FROM cmf_script WHERE id = 115');
    }
}
