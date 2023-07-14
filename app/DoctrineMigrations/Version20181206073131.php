<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181206073131 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cmf_script_selection (id INT AUTO_INCREMENT NOT NULL, cmf_script_id INT DEFAULT NULL, selection_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_C3757DC6BD0710B4 (cmf_script_id), INDEX IDX_C3757DC6E48EFE78 (selection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cmf_script_selection ADD CONSTRAINT FK_C3757DC6BD0710B4 FOREIGN KEY (cmf_script_id) REFERENCES cmf_script (id)');
        $this->addSql('ALTER TABLE cmf_script_selection ADD CONSTRAINT FK_C3757DC6E48EFE78 FOREIGN KEY (selection_id) REFERENCES selection (id)');
        $this->addSql('DROP TABLE cmfscript_selection');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cmfscript_selection (id INT AUTO_INCREMENT NOT NULL, cmf_script_id INT DEFAULT NULL, selection_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_A7EBD851BD0710B4 (cmf_script_id), INDEX IDX_A7EBD851E48EFE78 (selection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cmfscript_selection ADD CONSTRAINT FK_A7EBD851BD0710B4 FOREIGN KEY (cmf_script_id) REFERENCES cmf_script (id)');
        $this->addSql('ALTER TABLE cmfscript_selection ADD CONSTRAINT FK_A7EBD851E48EFE78 FOREIGN KEY (selection_id) REFERENCES selection (id)');
        $this->addSql('DROP TABLE cmf_script_selection');
    }
}
