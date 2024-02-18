<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218141129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie ADD matricule VARCHAR(255) DEFAULT NULL, ADD date_naissance DATE DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD ville VARCHAR(255) DEFAULT NULL, ADD date_embauche DATE DEFAULT NULL, ADD date_debut_contrat DATE DEFAULT NULL, ADD date_fin_contrat DATE DEFAULT NULL, ADD debut_periode_essai DATE DEFAULT NULL, ADD fin_periode_essai DATE DEFAULT NULL, ADD delai_preavis INT DEFAULT NULL, ADD num_cnss VARCHAR(255) DEFAULT NULL, ADD salaire_base DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie DROP matricule, DROP date_naissance, DROP adresse, DROP ville, DROP date_embauche, DROP date_debut_contrat, DROP date_fin_contrat, DROP debut_periode_essai, DROP fin_periode_essai, DROP delai_preavis, DROP num_cnss, DROP salaire_base');
    }
}
