<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423114738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B60D6DC42');
        $this->addSql('DROP INDEX IDX_27BA704B60D6DC42 ON history');
        $this->addSql('ALTER TABLE history CHANGE modules_id module_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_27BA704BAFC2B591 ON history (module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BAFC2B591');
        $this->addSql('DROP INDEX IDX_27BA704BAFC2B591 ON history');
        $this->addSql('ALTER TABLE history CHANGE module_id modules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B60D6DC42 FOREIGN KEY (modules_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_27BA704B60D6DC42 ON history (modules_id)');
    }
}
