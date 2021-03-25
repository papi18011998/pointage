<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325154401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depart CHANGE utilisateur_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE livraison ADD statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pointage ADD livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B208E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_7591B208E54FB25 ON pointage (livraison_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depart CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison DROP statut');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B208E54FB25');
        $this->addSql('DROP INDEX IDX_7591B208E54FB25 ON pointage');
        $this->addSql('ALTER TABLE pointage DROP livraison_id');
    }
}
