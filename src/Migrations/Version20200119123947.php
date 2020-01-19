<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200119123947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comptes ADD user_creator_id INT NOT NULL');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801C645C84A FOREIGN KEY (user_creator_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_56735801C645C84A ON comptes (user_creator_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801C645C84A');
        $this->addSql('DROP INDEX IDX_56735801C645C84A ON comptes');
        $this->addSql('ALTER TABLE comptes DROP user_creator_id');
    }
}
