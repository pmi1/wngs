<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190613113507 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item_color (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, color_id INT DEFAULT NULL, INDEX IDX_4CF15339126F525E (item_id), INDEX IDX_4CF153397ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_665648E9C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_color ADD CONSTRAINT FK_4CF15339126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_color ADD CONSTRAINT FK_4CF153397ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E9C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(164,   'Цвета',    120,    4,  1,  1,  NULL,   '/admin/app/itemcolor/list',    NULL,   '120/164',  'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\n<head>\n   <title></title>\n</head>\n<body></body>\n</html>',  'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\n<head>\n   <title></title>\n</head>\n<body></body>\n</html>',  4,  56, 57, 1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(165,   'Цвета',    116,    3,  1,  1,  NULL,   '/admin/app/color/list',    NULL,   '165',  'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\n<head>\n   <title></title>\n</head>\n<body></body>\n</html>',  'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\n<head>\n   <title></title>\n</head>\n<body></body>\n</html>',  6,  63, 64, 1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL);");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
(1, 165),
(2, 165),
(1, 164),
(2, 164)");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_color DROP FOREIGN KEY FK_4CF153397ADA1FB5');
        $this->addSql('DROP TABLE item_color');
        $this->addSql('DROP TABLE color');
        $this->addSql('DELETE FROM `role_script` WHERE `cmf_script_id` in (164, 165)');
        $this->addSql('DELETE FROM `cmf_script` WHERE `id` in (164, 165)');
    }
}
