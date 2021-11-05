<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104111900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resp_stock ADD entites_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resp_stock ADD CONSTRAINT FK_B9B9A43F573ACF92 FOREIGN KEY (entites_id) REFERENCES entites (id)');
        $this->addSql('CREATE INDEX IDX_B9B9A43F573ACF92 ON resp_stock (entites_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resp_stock DROP FOREIGN KEY FK_B9B9A43F573ACF92');
        $this->addSql('DROP INDEX IDX_B9B9A43F573ACF92 ON resp_stock');
        $this->addSql('ALTER TABLE resp_stock DROP entites_id');
    }
}
