<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190405081043 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, item_id INT DEFAULT NULL, price INT DEFAULT NULL, discount SMALLINT DEFAULT NULL, delivery VARCHAR(255)  DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, question LONGTEXT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, cdate DATETIME DEFAULT NULL, form_type INT DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), INDEX IDX_F5299398126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(158,   'Заказы',   116,    3,  1,  1,  NULL,   '/admin/app/order/list',    NULL,   '158',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 5,  57, 58, 1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
(1, 158),
(2, 158)");
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(159,   'Мои заказы',   143,    3,  1,  1,  'cabinetOrderPage', '/cabinet/order/',  NULL,   '143/159',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 6,  115,    116,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(160,   'Архив заказов',    159,    4,  1,  1,  'cabinetOrderArchivePage',  '/cabinet/order/?archive=1',    NULL,   '143/159/160',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 1,  116,    117,    1,  NULL,   0,  0,  0,  0,  NULL,   '\r\n', NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (4, 159), (4, 160)");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `order`');
    }
}
