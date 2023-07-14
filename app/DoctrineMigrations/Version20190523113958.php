<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190523113958 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(162,   'Заказы магазина',  143,    3,  1,  1,  'cabinetDesignerOrderPage', '/cabinet/dorder/', '', '143/162',  'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    7,  121,    124,    0,  '', 0,  0,  0,  0,  '', '', '', NULL),
(163,   'Архив заказов',    162,    4,  1,  1,  'cabinetDesignerOrderArchivePage',  '/cabinet/dorder/?archive=1',   '', '143/162/163',  'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    'richhtml', '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    '<html>\r\n<head>\r\n   <title></title>\r\n</head>\r\n<body></body>\r\n</html>',    1,  122,    123,    1,  '', 0,  0,  0,  0,  '', '', '', NULL);");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (4, 162), (4, 163)");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
