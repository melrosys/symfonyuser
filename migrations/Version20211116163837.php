<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211116163837 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salle_prod ADD product_id INT DEFAULT NULL, ADD sallestorage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle_prod ADD CONSTRAINT FK_83458174584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE salle_prod ADD CONSTRAINT FK_8345817F6FD16DD FOREIGN KEY (sallestorage_id) REFERENCES salle_storage (id)');
        $this->addSql('CREATE INDEX IDX_83458174584665A ON salle_prod (product_id)');
        $this->addSql('CREATE INDEX IDX_8345817F6FD16DD ON salle_prod (sallestorage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salle_prod DROP FOREIGN KEY FK_83458174584665A');
        $this->addSql('ALTER TABLE salle_prod DROP FOREIGN KEY FK_8345817F6FD16DD');
        $this->addSql('DROP INDEX IDX_83458174584665A ON salle_prod');
        $this->addSql('DROP INDEX IDX_8345817F6FD16DD ON salle_prod');
        $this->addSql('ALTER TABLE salle_prod DROP product_id, DROP sallestorage_id');
    }
}
