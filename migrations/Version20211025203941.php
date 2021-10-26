<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025203941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_B18C3541E7927C74 ON installateur (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_794C77655E237E06 ON salle_storage (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CABCB4925E237E06 ON stockage (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_B18C3541E7927C74 ON installateur');
        $this->addSql('DROP INDEX UNIQ_794C77655E237E06 ON salle_storage');
        $this->addSql('DROP INDEX UNIQ_CABCB4925E237E06 ON stockage');
    }
}
