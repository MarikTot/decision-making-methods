<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416122644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE alternatives_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE characteristics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrices_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tasks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE alternatives (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN alternatives.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('CREATE TABLE characteristics (id INT NOT NULL, name VARCHAR(255) NOT NULL, multiple BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matrices (id INT NOT NULL, alternative_id INT NOT NULL, characteristic_id INT NOT NULL, task_id INT NOT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX IDX_CD95A3BEFC05FFAC ON matrices (alternative_id)');
        $this->addSql('CREATE INDEX IDX_CD95A3BEDEE9D12B ON matrices (characteristic_id)');
        $this->addSql('CREATE INDEX IDX_CD95A3BE8DB60186 ON matrices (task_id)');

        $this->addSql('CREATE TABLE tasks (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');

        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT FK_CD95A3BEFC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT FK_CD95A3BEDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT FK_CD95A3BE8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('DROP SEQUENCE alternatives_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE characteristics_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrices_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tasks_id_seq CASCADE');

        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT FK_CD95A3BEFC05FFAC');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT FK_CD95A3BEDEE9D12B');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT FK_CD95A3BE8DB60186');

        $this->addSql('DROP TABLE alternatives');
        $this->addSql('DROP TABLE characteristics');
        $this->addSql('DROP TABLE matrices');
        $this->addSql('DROP TABLE tasks');
    }
}
