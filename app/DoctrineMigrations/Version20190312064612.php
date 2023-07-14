<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190312064612 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE maillist_template (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) DEFAULT NULL, from_name VARCHAR(255) DEFAULT NULL, from_email VARCHAR(255) DEFAULT NULL, to_name VARCHAR(255) DEFAULT NULL, to_email VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, text_raw LONGTEXT DEFAULT NULL, text_formatted LONGTEXT DEFAULT NULL, text_type LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO `maillist_template` (`id`, `subject`, `from_name`, `from_email`, `to_name`, `to_email`, `name`, `text_raw`, `text_formatted`, `text_type`) VALUES
(1, 'Новый запрос с формы \"Купить\"',  NULL,   NULL,   NULL,   NULL,   'Уведомление дизайнеру об сообщении с формы \"Купить\"',    '<p>Отправлен новый запрос на товар:<a href=\"{{ url(\'item_show\', {\'slug\': formAnswer.item.link|trim(\'/\')}) }}\">{{ formAnswer.item.name }}</a></p>\r\n\r\n<p>ФИО пользователя:&nbsp;{{ formAnswer.name }}</p>\r\n\r\n<p>Адрес: {{ formAnswer.comment }}</p>\r\n\r\n<p>Комментарий: {{ formAnswer.question }}</p>',   NULL,   'richhtml'),
(2, 'Новый запрос с формы \"Сообщение дизайнеру\"', NULL,   NULL,   NULL,   NULL,   'Уведомление дизайнеру об сообщении с формы \"Сообщение дизайнеру\"',   '<p>Отправлен новый запрос на товар:<a href=\"{{ url(\'item_show\', {\'slug\': formAnswer.item.link|trim(\'/\')}) }}\">{{ formAnswer.item.name }}</a></p>\r\n\r\n<p>ФИО пользователя:&nbsp;{{ formAnswer.name }}</p>\r\n\r\n<p>Тема: {{ formAnswer.comment }}</p>\r\n\r\n<p>Сообщение: {{ formAnswer.question }}</p>',  NULL,   'richhtml'),
(3, 'Новый запрос с формы \"Запросить скидку\"',    NULL,   NULL,   NULL,   NULL,   'Уведомление дизайнеру об сообщении с формы \"Запросить скидку\"',  '<p>Отправлен новый запрос на товар:<a href=\"{{ url(\'item_show\', {\'slug\': formAnswer.item.link|trim(\'/\')}) }}\">{{ formAnswer.item.name }}</a></p>\r\n\r\n<p>ФИО пользователя:&nbsp;{{ formAnswer.name }}</p>\r\n\r\n<p>Комментарий: {{ formAnswer.question }}</p>', NULL,   'richhtml'),
(4, 'Регистрация успешна',  NULL,   NULL,   NULL,   NULL,  'Уведомление пользователю после авторегистрации с форм',    '<p>&nbsp;</p>\r\n\r\n<p>Логин: {{ user.login }}</p>\r\n\r\n<p>Пароль: {{ user.password }}</p>',    NULL,   'richhtml'),
(5, 'Дизайнер добавил новую статью',    NULL,   NULL,   NULL,   NULL,   'Уведомление администратору о новой статье для модерации',  '<p>Добавлена новая статья:<a href=\"{{ url(\'admin_app_article_edit\', {\'id\': article.id}) }}\">{{ article.name }}</a></p>\r\n\r\n<p>ФИО пользователя:&nbsp;{{ article.user.name }}</p>\r\n\r\n<p>Название: {{ article.name }}</p>', NULL,   'richhtml')");

        $this->addSql("INSERT INTO `cmf_script` (`id`, `name`, `parent_id`, `depth`, `status`, `real_status`, `article`, `url`, `catname`, `realcatname`, `preview_type`, `preview_raw`, `preview_formatted`, `text_type`, `text_raw`, `text_formatted`, `ordering`, `left_margin`, `right_margin`, `lastnode`, `modelname`, `is_group_node`, `is_new_win`, `is_exclude_path`, `is_search`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`) VALUES
(153,   'Почтовые уведомления', 5,  3,  1,  1,  NULL,   '/admin/app/maillisttemplate/list', NULL,   '153',  'richhtml', NULL,   '', 'richhtml', NULL,   '', 2,  21, 22, 1,  NULL,   0,  0,  0,  0,  NULL,   NULL,   NULL,   NULL)");

        $this->addSql("INSERT INTO `role_script` (`role_id`, `cmf_script_id`) VALUES (1, 153),(2, 153)");

        $this->addSql("INSERT INTO `banner_place` (`id`, `name`, `status`, `deleted_at`, `updated_at`, `created_at`) VALUES
(13,    'Формы - сообщения об успешной отправке',   1,  NULL,   '2019-03-12 14:53:00',  '2019-03-12 14:53:00')");

        $this->addSql("INSERT INTO `page` (`id`, `deleted_at`, `name`, `status`, `text_raw`, `text_formatted`, `text_type`, `updated_at`, `created_at`, `image`, `link`, `ordering`, `banner_place_id`, `is_new_win`) VALUES
(100,   NULL,   'Форма \"Купить\"', 1,  '<div class=\"done\">Запрос отправлен</div>',   NULL,   'richhtml', '2019-03-12 15:12:12',  '2019-03-12 15:12:12',  NULL,   NULL,   NULL,   13, 0),
(101,   NULL,   'Форма \"Сообщение дизайнеру\"',    1,  '<div class=\"done\">Сообщение отправлено</div>',   NULL,   'richhtml', '2019-03-12 15:12:12',  '2019-03-12 15:12:12',  NULL,   NULL,   NULL,   13, 0),
(102,   NULL,   'Форма \"Запросить скидку\"',   1,  '<div class=\"done\">Запрос на скидку отправлен</div>', NULL,   'richhtml', '2019-03-12 15:12:12',  '2019-03-12 15:12:12',  NULL,   NULL,   NULL,   13, 0)");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE maillist_template');
    }
}
