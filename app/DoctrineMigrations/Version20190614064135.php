<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190614064135 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message ADD event_type INT(255) DEFAULT NULL, ADD is_new TINYINT(4) DEFAULT NULL');
        $this->addSql('UPDATE message SET event_type = 7');
        $this->addSql('UPDATE message SET is_new = 1');

        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(166,'Мои сообщения',143,3,1,1,'cabinetMessagePage','/cabinet/message/list/',NULL,'143/166','richhtml','<html>\r\n<head>\r\n    <title></title>\r\n</head>\r\n<body></body>\r\n</html>','<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>','richhtml','<html>\r\n<head>\r\n    <title></title>\r\n</head>\r\n<body></body>\r\n</html>','<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',8,125,126,1,NULL,0,0,0,0,NULL,NULL,NULL,NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (4, 166)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP event_type, DROP is_new');
        $this->addSql('DELETE FROM cmf_script WHERE id = 166');
        $this->addSql('DELETE FROM role_script WHERE cmf_script_id = 166');
    }
}
