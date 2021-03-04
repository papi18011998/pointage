<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303140004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depart (id INT AUTO_INCREMENT NOT NULL, jour DATE NOT NULL, heure_depart TIME NOT NULL, heure_retour DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, date_incident DATE NOT NULL, heure_incident TIME NOT NULL, commentaire VARCHAR(1000) NOT NULL, INDEX IDX_3D03A11AFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointage (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, heure_arrivee TIME NOT NULL, heur_sortie TIME NOT NULL, point_de_livraison VARCHAR(255) NOT NULL, commentaire VARCHAR(1000) DEFAULT NULL, INDEX IDX_7591B20FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, utlisateurs_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_57698A6A5C7E5010 (utlisateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, immatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A5C7E5010 FOREIGN KEY (utlisateurs_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD vehicule_id INT DEFAULT NULL, ADD depart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AE02FE4B FOREIGN KEY (depart_id) REFERENCES depart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B34A4A3511 ON utilisateur (vehicule_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3AE02FE4B ON utilisateur (depart_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3AE02FE4B');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34A4A3511');
        $this->addSql('DROP TABLE depart');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE pointage');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP INDEX UNIQ_1D1C63B34A4A3511 ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3AE02FE4B ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP vehicule_id, DROP depart_id');
    }
}
