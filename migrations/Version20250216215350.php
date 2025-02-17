<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216215350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, id_livreur INT NOT NULL, statut_commande VARCHAR(255) NOT NULL, date_commande DATETIME NOT NULL, produit VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX IDX_6EEAA67D35E7E71D (id_livreur), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id_livreur INT AUTO_INCREMENT NOT NULL, nom_livreur VARCHAR(255) NOT NULL, prenom_livreur VARCHAR(255) NOT NULL, mail_livreur VARCHAR(255) NOT NULL, telephone_livreur INT NOT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id_livreur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D35E7E71D FOREIGN KEY (id_livreur) REFERENCES livreur (id_livreur)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D35E7E71D');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE livreur');
    }
}
