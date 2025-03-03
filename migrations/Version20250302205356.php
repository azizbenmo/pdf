<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302205356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, livreur_commande_id INT NOT NULL, statue_commande VARCHAR(255) NOT NULL, date_commande DATETIME NOT NULL, prixtotal_commande DOUBLE PRECISION NOT NULL, modepaiement_commande VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67DB79CC9C2 (livreur_commande_id), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, nom_livreur VARCHAR(255) NOT NULL, prenom_livreur VARCHAR(255) NOT NULL, numero_livreur INT NOT NULL, addresse_livreur VARCHAR(255) NOT NULL, photo_livreur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur_position (id INT AUTO_INCREMENT NOT NULL, livreur_id INT NOT NULL, id_commande INT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, last_update DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CD4C739DF8646701 (livreur_id), INDEX IDX_CD4C739D3E314AE8 (id_commande), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendu (id_rendu INT AUTO_INCREMENT NOT NULL, message_rendu VARCHAR(255) NOT NULL, type_rendu VARCHAR(255) NOT NULL, date_envoi_rendu DATE NOT NULL, PRIMARY KEY(id_rendu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB79CC9C2 FOREIGN KEY (livreur_commande_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE livreur_position ADD CONSTRAINT FK_CD4C739DF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE livreur_position ADD CONSTRAINT FK_CD4C739D3E314AE8 FOREIGN KEY (id_commande) REFERENCES commande (id_commande)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DB79CC9C2');
        $this->addSql('ALTER TABLE livreur_position DROP FOREIGN KEY FK_CD4C739DF8646701');
        $this->addSql('ALTER TABLE livreur_position DROP FOREIGN KEY FK_CD4C739D3E314AE8');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE livreur_position');
        $this->addSql('DROP TABLE rendu');
    }
}
