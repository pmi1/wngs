<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170606075746 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cmf_rights DROP INDEX IDX_7CDF134A1C01850, ADD UNIQUE INDEX UNIQ_7CDF134A1C01850 (script_id)');
        $this->addSql('ALTER TABLE compare ADD created DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX user_clinic ON compare (user_token, clinic_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cmf_rights DROP INDEX UNIQ_7CDF134A1C01850, ADD INDEX IDX_7CDF134A1C01850 (script_id)');
        $this->addSql('DROP INDEX user_clinic ON compare');
        $this->addSql('ALTER TABLE compare DROP created');
    }
}
