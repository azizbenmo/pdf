<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302073842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, reclamation_id INT NOT NULL, message LONGTEXT NOT NULL, response LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FAB3FC162D6BA2D9 (reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feed (id INT AUTO_INCREMENT NOT NULL, email_feed VARCHAR(255) NOT NULL, commentaire_feed LONGTEXT NOT NULL, subject_feed VARCHAR(255) NOT NULL, date_feed DATETIME NOT NULL, name_feed VARCHAR(255) NOT NULL, is_processed TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, description_rec VARCHAR(255) NOT NULL, statut_rec VARCHAR(255) NOT NULL, date_rec DATETIME NOT NULL, message_reclamation LONGTEXT DEFAULT NULL, historique_conversations LONGTEXT DEFAULT NULL, INDEX IDX_CE606404FB88E14F (utilisateur_id), INDEX IDX_CE606404F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation_message (id INT AUTO_INCREMENT NOT NULL, reclamation_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, content LONGTEXT NOT NULL, sent_at DATETIME NOT NULL, is_from_admin TINYINT(1) NOT NULL, INDEX IDX_6797EEEE2D6BA2D9 (reclamation_id), INDEX IDX_6797EEEEF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC162D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_user)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE reclamation_message ADD CONSTRAINT FK_6797EEEE2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE reclamation_message ADD CONSTRAINT FK_6797EEEEF624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC162D6BA2D9');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FB88E14F');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F347EFB');
        $this->addSql('ALTER TABLE reclamation_message DROP FOREIGN KEY FK_6797EEEE2D6BA2D9');
        $this->addSql('ALTER TABLE reclamation_message DROP FOREIGN KEY FK_6797EEEEF624B39D');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE feed');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reclamation_message');
    }
}
