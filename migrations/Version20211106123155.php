<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211106123155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salle_storage ADD entites_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle_storage ADD CONSTRAINT FK_794C7765573ACF92 FOREIGN KEY (entites_id) REFERENCES entites (id)');
        $this->addSql('CREATE INDEX IDX_794C7765573ACF92 ON salle_storage (entites_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salle_storage DROP FOREIGN KEY FK_794C7765573ACF92');
        $this->addSql('DROP INDEX IDX_794C7765573ACF92 ON salle_storage');
        $this->addSql('ALTER TABLE salle_storage DROP entites_id');
    }
}
