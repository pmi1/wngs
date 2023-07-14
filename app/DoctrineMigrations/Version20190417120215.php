<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190417120215 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, `user_from` INT DEFAULT NULL, `user_to` INT DEFAULT NULL, cdate DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_790009E38D9F6D38 (order_id), INDEX IDX_790009E3B91AA170 (`user_from`), INDEX IDX_790009E3D787D2C4 (`user_to`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_790009E38D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_790009E3B91AA170 FOREIGN KEY (`user_from`) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_790009E3D787D2C4 FOREIGN KEY (`user_to`) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(161,   'Сообщения',    5,  3,  1,  1,  NULL,   '/admin/app/message/list',  NULL,   '161',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 26, 39, 40, 1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
(1, 161),
(2, 161)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE message');
    }
}
