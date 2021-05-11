<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511135607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE film_film (film_source INT NOT NULL, film_target INT NOT NULL, INDEX IDX_E7EB542134784279 (film_source), INDEX IDX_E7EB54212D9D12F6 (film_target), PRIMARY KEY(film_source, film_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE film_film ADD CONSTRAINT FK_E7EB542134784279 FOREIGN KEY (film_source) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_film ADD CONSTRAINT FK_E7EB54212D9D12F6 FOREIGN KEY (film_target) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD film_id INT DEFAULT NULL, ADD avis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC197E709F FOREIGN KEY (avis_id) REFERENCES film (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC567F5183 ON commentaire (film_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC197E709F ON commentaire (avis_id)');
        $this->addSql('ALTER TABLE film ADD dispo VARCHAR(255) DEFAULT NULL, ADD bande_annonce LONGTEXT DEFAULT NULL, ADD ost LONGTEXT DEFAULT NULL, ADD affiche VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE film_film');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC567F5183');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC197E709F');
        $this->addSql('DROP INDEX IDX_67F068BC567F5183 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC197E709F ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP film_id, DROP avis_id');
        $this->addSql('ALTER TABLE film DROP dispo, DROP bande_annonce, DROP ost, DROP affiche');
    }
}
