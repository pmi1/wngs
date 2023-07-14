<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181205070544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495E237E06 ON user (name)');
        $this->addSql('ALTER TABLE catalogue ADD image INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F5C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_59A699F5C53D045F ON catalogue (image)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F5C53D045F');
        $this->addSql('DROP INDEX IDX_59A699F5C53D045F ON catalogue');
        $this->addSql('ALTER TABLE catalogue DROP image');
        $this->addSql('DROP INDEX UNIQ_8D93D6495E237E06 ON user');
    }
}
