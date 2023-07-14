<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190708092259 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD active_catalogue TINYINT(1) DEFAULT \'0\'');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(167,   'Кабинет - верхнее меню',   2,  2,  1,  1,  NULL,   NULL,   'cabinet',  'cabinet',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 4,  132,    143,    0,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(168,   'События',  167,    3,  1,  1,  NULL,   NULL,   NULL,   'cabinet/168',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 1,  133,    134,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(169,   'Поддержка',    167,    3,  1,  1,  NULL,   NULL,   NULL,   'cabinet/169',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 2,  135,    136,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(170,   'Развитие бренда',  167,    3,  1,  1,  NULL,   NULL,   NULL,   'cabinet/170',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 3,  137,    138,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(171,   'Обучение', 167,    3,  1,  1,  NULL,   NULL,   NULL,   'cabinet/171',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 4,  139,    140,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL),
(172,   'Публикации дизайнеров',    167,    3,  1,  1,  NULL,   NULL,   NULL,   'cabinet/172',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 5,  141,    142,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES
(4, 167),
(4, 168),
(4, 169),
(4, 170),
(4, 171),
(4, 172)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP active_catalogue');
    }
}
