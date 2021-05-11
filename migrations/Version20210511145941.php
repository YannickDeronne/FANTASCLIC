<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511145941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC197E709F');
        $this->addSql('DROP INDEX IDX_67F068BC197E709F ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP avis_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD avis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC197E709F FOREIGN KEY (avis_id) REFERENCES film (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC197E709F ON commentaire (avis_id)');
    }
}
