<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611153150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matrices ADD created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT FK_CD95A3BEB03A8386 FOREIGN KEY (created_by_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CD95A3BEB03A8386 ON matrices (created_by_id)');
        $this->addSql('ALTER TABLE tasks ADD created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597B03A8386 FOREIGN KEY (created_by_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_50586597B03A8386 ON tasks (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597B03A8386');
        $this->addSql('DROP INDEX IDX_50586597B03A8386');
        $this->addSql('ALTER TABLE tasks DROP created_by_id');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT FK_CD95A3BEB03A8386');
        $this->addSql('DROP INDEX IDX_CD95A3BEB03A8386');
        $this->addSql('ALTER TABLE matrices DROP created_by_id');
    }
}
