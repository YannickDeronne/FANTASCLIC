<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514080842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film ADD sj_id INT DEFAULT NULL, DROP sj');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22B5CB6647 FOREIGN KEY (sj_id) REFERENCES sj (id)');
        $this->addSql('CREATE INDEX IDX_8244BE22B5CB6647 ON film (sj_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22B5CB6647');
        $this->addSql('DROP INDEX IDX_8244BE22B5CB6647 ON film');
        $this->addSql('ALTER TABLE film ADD sj VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP sj_id');
    }
}
