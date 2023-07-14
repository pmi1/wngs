<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181214134320 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE selection ADD image INT DEFAULT NULL');
        $this->addSql('ALTER TABLE selection ADD CONSTRAINT FK_96A50CD7C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_96A50CD7C53D045F ON selection (image)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE selection DROP FOREIGN KEY FK_96A50CD7C53D045F');
        $this->addSql('DROP INDEX IDX_96A50CD7C53D045F ON selection');
        $this->addSql('ALTER TABLE selection DROP image');
    }
}
