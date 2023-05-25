<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525223341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE matrix_decision_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matrix_decision (id INT NOT NULL, matrix_id INT NOT NULL, created_by_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, method VARCHAR(255) NOT NULL, result JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_486FD179AA000BE7 ON matrix_decision (matrix_id)');
        $this->addSql('CREATE INDEX IDX_486FD179B03A8386 ON matrix_decision (created_by_id)');
        $this->addSql('COMMENT ON COLUMN matrix_decision.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE matrix_decision ADD CONSTRAINT FK_486FD179AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_decision ADD CONSTRAINT FK_486FD179B03A8386 FOREIGN KEY (created_by_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE matrix_decision_id_seq CASCADE');
        $this->addSql('ALTER TABLE matrix_decision DROP CONSTRAINT FK_486FD179AA000BE7');
        $this->addSql('ALTER TABLE matrix_decision DROP CONSTRAINT FK_486FD179B03A8386');
        $this->addSql('DROP TABLE matrix_decision');
    }
}
