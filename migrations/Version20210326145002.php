<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326145002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depart (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, vehicule_id INT DEFAULT NULL, jour DATE NOT NULL, heure_depart TIME NOT NULL, heure_retour DATE DEFAULT NULL, INDEX IDX_1B3EBB08FB88E14F (utilisateur_id), INDEX IDX_1B3EBB084A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, date_incident DATE NOT NULL, heure_incident TIME NOT NULL, commentaire VARCHAR(1000) NOT NULL, INDEX IDX_3D03A11AFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointage (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, livraison_id INT DEFAULT NULL, heure_arrivee TIME NOT NULL, heur_sortie TIME NOT NULL, point_de_livraison VARCHAR(255) NOT NULL, commentaire VARCHAR(1000) DEFAULT NULL, INDEX IDX_7591B20FB88E14F (utilisateur_id), INDEX IDX_7591B208E54FB25 (livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B3D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_vehicule (utilisateur_id INT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_37540682FB88E14F (utilisateur_id), INDEX IDX_375406824A4A3511 (vehicule_id), PRIMARY KEY(utilisateur_id, vehicule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, immatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depart ADD CONSTRAINT FK_1B3EBB08FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE depart ADD CONSTRAINT FK_1B3EBB084A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B208E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE utilisateur_vehicule ADD CONSTRAINT FK_37540682FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_vehicule ADD CONSTRAINT FK_375406824A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B208E54FB25');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('ALTER TABLE depart DROP FOREIGN KEY FK_1B3EBB08FB88E14F');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AFB88E14F');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_vehicule DROP FOREIGN KEY FK_37540682FB88E14F');
        $this->addSql('ALTER TABLE depart DROP FOREIGN KEY FK_1B3EBB084A4A3511');
        $this->addSql('ALTER TABLE utilisateur_vehicule DROP FOREIGN KEY FK_375406824A4A3511');
        $this->addSql('DROP TABLE depart');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE pointage');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_vehicule');
        $this->addSql('DROP TABLE vehicule');
    }
}
