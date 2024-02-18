<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218114828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie ADD dossier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salarie ADD CONSTRAINT FK_828E3A1A611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('CREATE INDEX IDX_828E3A1A611C0C56 ON salarie (dossier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie DROP FOREIGN KEY FK_828E3A1A611C0C56');
        $this->addSql('DROP INDEX IDX_828E3A1A611C0C56 ON salarie');
        $this->addSql('ALTER TABLE salarie DROP dossier_id');
    }
}
