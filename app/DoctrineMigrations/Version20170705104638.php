<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170705104638 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country_disease CHANGE favourite favourite TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE disease CHANGE fav fav TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE disease_country CHANGE enabled enabled TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE favourite favourite TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE opinion CHANGE priority priority TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE show_on_main show_on_main TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE privilege CHANGE is_read is_read TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_write is_write TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_insert is_insert TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_delete is_delete TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F801210EE4CEE');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F8012C5760F86');
        $this->addSql('DROP INDEX IDX_AB4F801210EE4CEE ON related_clinic');
        $this->addSql('DROP INDEX IDX_AB4F8012C5760F86 ON related_clinic');
        $this->addSql('ALTER TABLE related_clinic ADD parent INT DEFAULT NULL, ADD rel_clinic INT DEFAULT NULL, DROP parentId, DROP relClinicId');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F80123D8E604F FOREIGN KEY (parent) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F8012E35A8C85 FOREIGN KEY (rel_clinic) REFERENCES clinic (id)');
        $this->addSql('CREATE INDEX IDX_AB4F80123D8E604F ON related_clinic (parent)');
        $this->addSql('CREATE INDEX IDX_AB4F8012E35A8C85 ON related_clinic (rel_clinic)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country_disease CHANGE favourite favourite TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE disease CHANGE fav fav TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE disease_country CHANGE enabled enabled TINYINT(1) NOT NULL, CHANGE favourite favourite TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE opinion CHANGE show_on_main show_on_main TINYINT(1) NOT NULL, CHANGE priority priority TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE privilege CHANGE is_read is_read TINYINT(1) NOT NULL, CHANGE is_write is_write TINYINT(1) NOT NULL, CHANGE is_insert is_insert TINYINT(1) NOT NULL, CHANGE is_delete is_delete TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F80123D8E604F');
        $this->addSql('ALTER TABLE related_clinic DROP FOREIGN KEY FK_AB4F8012E35A8C85');
        $this->addSql('DROP INDEX IDX_AB4F80123D8E604F ON related_clinic');
        $this->addSql('DROP INDEX IDX_AB4F8012E35A8C85 ON related_clinic');
        $this->addSql('ALTER TABLE related_clinic ADD parentId INT DEFAULT NULL, ADD relClinicId INT DEFAULT NULL, DROP parent, DROP rel_clinic');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F801210EE4CEE FOREIGN KEY (parentId) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE related_clinic ADD CONSTRAINT FK_AB4F8012C5760F86 FOREIGN KEY (relClinicId) REFERENCES clinic (id)');
        $this->addSql('CREATE INDEX IDX_AB4F801210EE4CEE ON related_clinic (parentId)');
        $this->addSql('CREATE INDEX IDX_AB4F8012C5760F86 ON related_clinic (relClinicId)');
    }
}
