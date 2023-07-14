<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190418133733 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_790009E3B91AA170');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_790009E3D787D2C4');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('DROP INDEX idx_790009e3b91aa170 ON message');
        $this->addSql('CREATE INDEX IDX_B6BD307FC39BEDB9 ON message (user_from)');
        $this->addSql('DROP INDEX idx_790009e3d787d2c4 ON message');
        $this->addSql('CREATE INDEX IDX_B6BD307FCFD06601 ON message (user_to)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_790009E3B91AA170 FOREIGN KEY (user_from) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_790009E3D787D2C4 FOREIGN KEY (user_to) REFERENCES user (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8D9F6D38');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC39BEDB9');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCFD06601');
        $this->addSql('DROP INDEX idx_b6bd307fc39bedb9 ON message');
        $this->addSql('CREATE INDEX IDX_790009E3B91AA170 ON message (user_from)');
        $this->addSql('DROP INDEX idx_b6bd307fcfd06601 ON message');
        $this->addSql('CREATE INDEX IDX_790009E3D787D2C4 ON message (user_to)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC39BEDB9 FOREIGN KEY (user_from) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCFD06601 FOREIGN KEY (user_to) REFERENCES user (id) ON DELETE SET NULL');
    }
}
