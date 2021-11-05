<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103113318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resp_stock ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resp_stock ADD CONSTRAINT FK_B9B9A43FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9B9A43FA76ED395 ON resp_stock (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resp_stock DROP FOREIGN KEY FK_B9B9A43FA76ED395');
        $this->addSql('DROP INDEX UNIQ_B9B9A43FA76ED395 ON resp_stock');
        $this->addSql('ALTER TABLE resp_stock DROP user_id');
    }
}
