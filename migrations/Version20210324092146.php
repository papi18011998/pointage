<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324092146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_vehicule (utilisateur_id INT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_37540682FB88E14F (utilisateur_id), INDEX IDX_375406824A4A3511 (vehicule_id), PRIMARY KEY(utilisateur_id, vehicule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_vehicule ADD CONSTRAINT FK_37540682FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_vehicule ADD CONSTRAINT FK_375406824A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34A4A3511');
        $this->addSql('DROP INDEX UNIQ_1D1C63B34A4A3511 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP vehicule_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur_vehicule');
        $this->addSql('ALTER TABLE utilisateur ADD vehicule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B34A4A3511 ON utilisateur (vehicule_id)');
    }
}
