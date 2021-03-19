<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210319085925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depart ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE depart ADD CONSTRAINT FK_1B3EBB08FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1B3EBB08FB88E14F ON depart (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3AE02FE4B');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3AE02FE4B ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP depart_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depart DROP FOREIGN KEY FK_1B3EBB08FB88E14F');
        $this->addSql('DROP INDEX IDX_1B3EBB08FB88E14F ON depart');
        $this->addSql('ALTER TABLE depart DROP utilisateur_id');
        $this->addSql('ALTER TABLE utilisateur ADD depart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AE02FE4B FOREIGN KEY (depart_id) REFERENCES depart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3AE02FE4B ON utilisateur (depart_id)');
    }
}
