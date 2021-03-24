<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324111226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depart CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depart ADD CONSTRAINT FK_1B3EBB084A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_1B3EBB084A4A3511 ON depart (vehicule_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depart DROP FOREIGN KEY FK_1B3EBB084A4A3511');
        $this->addSql('DROP INDEX IDX_1B3EBB084A4A3511 ON depart');
        $this->addSql('ALTER TABLE depart CHANGE utilisateur_id utilisateur_id INT NOT NULL');
    }
}
