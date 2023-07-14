<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190314064631 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_selection ADD status TINYINT(1) DEFAULT \'1\' NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(154,   'Мой каталог',  143,    3,  1,  1,  'cabinetCatPage',   '/cabinet/cat/',    NULL,   '143/154',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 3,  107,    108,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (4, 154)");
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(156,   'Мои коллекции',    143,    3,  1,  1,  'cabinetSelectionPage', '/cabinet/selection/',  NULL,   '143/156',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 4,  109,    110,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (4, 156)");
        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(157,   'Мои статьи',   143,    3,  1,  1,  'cabinetArticlePage',   '/cabinet/article/',    NULL,   '143/157',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 5,  111,    112,    1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");
        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (4, 157)");
        $this->addSql("INSERT INTO `banner_place` (`id`, `name`, `status`, `deleted_at`, `updated_at`, `created_at`) VALUES
(14,    'Подсказки на странице Мой каталог',    1,  NULL,   '2019-03-27 15:00:10',  '2019-03-27 15:00:10'),
(15,    'Входная страница кабинета дизайнера - текстовые блоки',    1,  NULL,   '2019-04-03 11:22:12',  '2019-04-03 11:22:12'),
(16,    'Входная страница кабинета дизайнера - Selected Professional',  1,  NULL,   '2019-04-03 15:01:19',  '2019-04-03 11:22:12'),
(17,    'Входная страница кабинета дизайнера - Fashion Incubator',  1,  NULL,   '2019-04-03 15:36:04',  '2019-04-03 11:22:12'),
(18,    'Входная страница кабинета дизайнера - баннер внизу',   1,  NULL,   '2019-04-03 14:57:04',  '2019-04-03 11:22:12')");
        $this->addSql("INSERT INTO `page` (`id`, `deleted_at`, `name`, `status`, `text_raw`, `text_formatted`, `text_type`, `updated_at`, `created_at`, `image`, `link`, `ordering`, `banner_place_id`, `is_new_win`) VALUES
(103,   NULL,   'ОПУБЛИКОВАТЬ В PROMO', 1,  '<p>Лввыэажы<strong><u>вжаыва</u></strong></p>',    NULL,   'richhtml', '2019-03-27 15:00:10',  '2019-03-27 15:00:10',  NULL,   'Это просто тестовая подсказка',    NULL,   14, 0),
(104,   NULL,   'SALE', 1,  '<p>sdfsdfsdfsdf</p>',  NULL,   'richhtml', '2019-03-27 15:00:10',  '2019-03-27 15:00:10',  NULL,   'kkfdgfg',  NULL,   14, 0),
(106,   NULL,   'Новость 4 Апреля 2018',    1,  '<p>Гоша Рубчинский объявил о закрытии своего бренда Нас ждет что-то новое. Сегодня в своем Instagram один из самых популярных дизайнеров современности Гоша Рубчинский опубликовал пост, который очень удивил поклонников марки. В нем говорится о том, что теперь бренд ГОША РУБЧИНСКИЙ в таком виде, каким его знает широкая публика, больше существовать не будет.</p>',    NULL,   'richhtml', '2019-04-03 11:22:12',  '2019-04-03 11:22:12',  NULL,   NULL,   NULL,   15, 0),
(107,   NULL,   'Обьявление 4 Апреля 2018', 1,  '<section>\r\n<p>В &laquo;Петровском пассаже&raquo; заработало pop-up пространство Bosco Ceremony &mdash; проект, посвященный свадебной моде. Невесты и их подружки смогут найти свадебные и вечерние платья (а также пошить их на заказ) и приобрести обувь и аксессуары. Помимо этого здесь доступна услуга wish-list и консьерж-служба Bosco Prive.</p>\r\n</section>',  NULL,   'richhtml', '2019-04-03 11:22:12',  '2019-04-03 11:22:12',  NULL,   NULL,   NULL,   15, 0),
(108,   NULL,   NULL,   1,  NULL,   NULL,   'richhtml', '2019-04-03 14:57:04',  '2019-04-03 14:57:04',  1922,   NULL,   NULL,   18, 0),
(109,   NULL,   '8 марта',  1,  '<p>Героиней бренда стала современная городская, образованная модница, естественная и романтичная</p>', NULL,   'richhtml', '2019-04-03 15:01:19',  '2019-04-03 15:01:19',  820,    NULL,   NULL,   16, 0),
(110,   NULL,   'Героиня бренда',   1,  '<p>Героиней бренда стала современная городская, образованная модница, естественная и романтичная</p>', NULL,   'richhtml', '2019-04-03 15:01:19',  '2019-04-03 15:01:19',  821,    NULL,   NULL,   16, 0),
(111,   NULL,   '23 февраля',   1,  '<p>Героиней бренда стала современная городская, образованная модница, естественная и романтичная</p>', NULL,   'richhtml', '2019-04-03 15:36:04',  '2019-04-03 15:36:04',  1074,   NULL,   NULL,   17, 0),
(112,   NULL,   '14 апреля',    1,  '<p>Героиней бренда стала современная городская, образованная модница, естественная и романтичная 2</p>',   NULL,   'richhtml', '2019-04-03 15:36:04',  '2019-04-03 15:36:04',  819,    NULL,   NULL,   17, 0)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_selection DROP status, DROP created_at');
    }
}
