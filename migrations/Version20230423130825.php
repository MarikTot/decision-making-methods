<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423130825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE characteristic_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE characteristic_type_enum_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE characteristic_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, default_type BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE characteristic_type_enum (id INT NOT NULL, type_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F122F0DFC54C8C93 ON characteristic_type_enum (type_id)');
        $this->addSql('ALTER TABLE characteristic_type_enum ADD CONSTRAINT FK_F122F0DFC54C8C93 FOREIGN KEY (type_id) REFERENCES characteristic_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characteristics ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE characteristics ADD CONSTRAINT FK_7037B156C54C8C93 FOREIGN KEY (type_id) REFERENCES characteristic_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7037B156C54C8C93 ON characteristics (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('ALTER TABLE characteristics DROP CONSTRAINT FK_7037B156C54C8C93');
        $this->addSql('DROP SEQUENCE characteristic_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE characteristic_type_enum_id_seq CASCADE');
        $this->addSql('ALTER TABLE characteristic_type_enum DROP CONSTRAINT FK_F122F0DFC54C8C93');
        $this->addSql('DROP TABLE characteristic_type');
        $this->addSql('DROP TABLE characteristic_type_enum');
        $this->addSql('DROP INDEX IDX_7037B156C54C8C93');
        $this->addSql('ALTER TABLE characteristics DROP type_id');
    }
}
