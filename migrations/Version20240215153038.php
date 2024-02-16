<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215153038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prime_salarie (id INT AUTO_INCREMENT NOT NULL, salarie_id INT NOT NULL, prime_id INT NOT NULL, montant NUMERIC(10, 2) NOT NULL, INDEX IDX_F761C2F55859934A (salarie_id), INDEX IDX_F761C2F569247986 (prime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prime_salarie ADD CONSTRAINT FK_F761C2F55859934A FOREIGN KEY (salarie_id) REFERENCES salarie (id)');
        $this->addSql('ALTER TABLE prime_salarie ADD CONSTRAINT FK_F761C2F569247986 FOREIGN KEY (prime_id) REFERENCES prime (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prime_salarie DROP FOREIGN KEY FK_F761C2F55859934A');
        $this->addSql('ALTER TABLE prime_salarie DROP FOREIGN KEY FK_F761C2F569247986');
        $this->addSql('DROP TABLE prime_salarie');
    }
}
