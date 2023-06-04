<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528115943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE alternatives_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cells_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE characteristics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE conditions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrices_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_alternative_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_characteristic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE results_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tasks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_enums_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "users_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE values_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE alternatives (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX alternative_name_idx ON alternatives (name)');
        $this->addSql('COMMENT ON COLUMN alternatives.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE cells (id INT NOT NULL, alternative_id INT NOT NULL, characteristic_id INT NOT NULL, matrix_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_55C1CBD8FC05FFAC ON cells (alternative_id)');
        $this->addSql('CREATE INDEX IDX_55C1CBD8DEE9D12B ON cells (characteristic_id)');
        $this->addSql('CREATE INDEX IDX_55C1CBD8AA000BE7 ON cells (matrix_id)');
        $this->addSql('CREATE INDEX cell_matrix_alternative_characteristic_idx ON cells (matrix_id, alternative_id, characteristic_id)');
        $this->addSql('CREATE TABLE characteristics (id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, multiple BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7037B156C54C8C93 ON characteristics (type_id)');
        $this->addSql('CREATE INDEX characteristic_name_idx ON characteristics (name)');
        $this->addSql('CREATE TABLE conditions (id INT NOT NULL, characteristic_id INT NOT NULL, task_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F46609A9DEE9D12B ON conditions (characteristic_id)');
        $this->addSql('CREATE INDEX IDX_F46609A98DB60186 ON conditions (task_id)');
        $this->addSql('CREATE TABLE matrices (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX matrix_title_idx ON matrices (title)');
        $this->addSql('CREATE TABLE matrix_alternative (id INT NOT NULL, matrix_id INT NOT NULL, alternative_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CB5E36F3AA000BE7 ON matrix_alternative (matrix_id)');
        $this->addSql('CREATE INDEX IDX_CB5E36F3FC05FFAC ON matrix_alternative (alternative_id)');
        $this->addSql('CREATE INDEX matrix_alternative_idx ON matrix_alternative (matrix_id, alternative_id)');
        $this->addSql('COMMENT ON COLUMN matrix_alternative.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE matrix_characteristic (id INT NOT NULL, matrix_id INT NOT NULL, characteristic_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A26B308AA000BE7 ON matrix_characteristic (matrix_id)');
        $this->addSql('CREATE INDEX IDX_7A26B308DEE9D12B ON matrix_characteristic (characteristic_id)');
        $this->addSql('CREATE INDEX matrix_characteristic_idx ON matrix_characteristic (matrix_id, characteristic_id)');
        $this->addSql('COMMENT ON COLUMN matrix_characteristic.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE results (id INT NOT NULL, created_by_id INT NOT NULL, task_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, method VARCHAR(255) NOT NULL, result JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FA3E414B03A8386 ON results (created_by_id)');
        $this->addSql('CREATE INDEX IDX_9FA3E4148DB60186 ON results (task_id)');
        $this->addSql('COMMENT ON COLUMN results.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tasks (id INT NOT NULL, matrix_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50586597AA000BE7 ON tasks (matrix_id)');
        $this->addSql('CREATE TABLE task_alternative (task_id INT NOT NULL, alternative_id INT NOT NULL, PRIMARY KEY(task_id, alternative_id))');
        $this->addSql('CREATE INDEX IDX_488AF0C88DB60186 ON task_alternative (task_id)');
        $this->addSql('CREATE INDEX IDX_488AF0C8FC05FFAC ON task_alternative (alternative_id)');
        $this->addSql('CREATE TABLE task_characteristic (task_id INT NOT NULL, characteristic_id INT NOT NULL, PRIMARY KEY(task_id, characteristic_id))');
        $this->addSql('CREATE INDEX IDX_4E06DFFF8DB60186 ON task_characteristic (task_id)');
        $this->addSql('CREATE INDEX IDX_4E06DFFFDEE9D12B ON task_characteristic (characteristic_id)');
        $this->addSql('CREATE TABLE type_enums (id INT NOT NULL, type_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9609730C54C8C93 ON type_enums (type_id)');
        $this->addSql('CREATE TABLE types (id INT NOT NULL, name VARCHAR(255) NOT NULL, is_number BOOLEAN DEFAULT false NOT NULL, default_type BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "users" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON "users" (username)');
        $this->addSql('CREATE TABLE values (id INT NOT NULL, cell_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AA74CE6CB39D93A ON values (cell_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE cells ADD CONSTRAINT FK_55C1CBD8FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cells ADD CONSTRAINT FK_55C1CBD8DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cells ADD CONSTRAINT FK_55C1CBD8AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characteristics ADD CONSTRAINT FK_7037B156C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A9DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A98DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_alternative ADD CONSTRAINT FK_CB5E36F3AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_alternative ADD CONSTRAINT FK_CB5E36F3FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_characteristic ADD CONSTRAINT FK_7A26B308AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_characteristic ADD CONSTRAINT FK_7A26B308DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E414B03A8386 FOREIGN KEY (created_by_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E4148DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_alternative ADD CONSTRAINT FK_488AF0C88DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_alternative ADD CONSTRAINT FK_488AF0C8FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_characteristic ADD CONSTRAINT FK_4E06DFFF8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_characteristic ADD CONSTRAINT FK_4E06DFFFDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE type_enums ADD CONSTRAINT FK_9609730C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE values ADD CONSTRAINT FK_3AA74CE6CB39D93A FOREIGN KEY (cell_id) REFERENCES cells (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE alternatives_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cells_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE characteristics_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE conditions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrices_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_alternative_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_characteristic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE results_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tasks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_enums_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE types_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "users_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE values_id_seq CASCADE');
        $this->addSql('ALTER TABLE cells DROP CONSTRAINT FK_55C1CBD8FC05FFAC');
        $this->addSql('ALTER TABLE cells DROP CONSTRAINT FK_55C1CBD8DEE9D12B');
        $this->addSql('ALTER TABLE cells DROP CONSTRAINT FK_55C1CBD8AA000BE7');
        $this->addSql('ALTER TABLE characteristics DROP CONSTRAINT FK_7037B156C54C8C93');
        $this->addSql('ALTER TABLE conditions DROP CONSTRAINT FK_F46609A9DEE9D12B');
        $this->addSql('ALTER TABLE conditions DROP CONSTRAINT FK_F46609A98DB60186');
        $this->addSql('ALTER TABLE matrix_alternative DROP CONSTRAINT FK_CB5E36F3AA000BE7');
        $this->addSql('ALTER TABLE matrix_alternative DROP CONSTRAINT FK_CB5E36F3FC05FFAC');
        $this->addSql('ALTER TABLE matrix_characteristic DROP CONSTRAINT FK_7A26B308AA000BE7');
        $this->addSql('ALTER TABLE matrix_characteristic DROP CONSTRAINT FK_7A26B308DEE9D12B');
        $this->addSql('ALTER TABLE results DROP CONSTRAINT FK_9FA3E414B03A8386');
        $this->addSql('ALTER TABLE results DROP CONSTRAINT FK_9FA3E4148DB60186');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597AA000BE7');
        $this->addSql('ALTER TABLE task_alternative DROP CONSTRAINT FK_488AF0C88DB60186');
        $this->addSql('ALTER TABLE task_alternative DROP CONSTRAINT FK_488AF0C8FC05FFAC');
        $this->addSql('ALTER TABLE task_characteristic DROP CONSTRAINT FK_4E06DFFF8DB60186');
        $this->addSql('ALTER TABLE task_characteristic DROP CONSTRAINT FK_4E06DFFFDEE9D12B');
        $this->addSql('ALTER TABLE type_enums DROP CONSTRAINT FK_9609730C54C8C93');
        $this->addSql('ALTER TABLE values DROP CONSTRAINT FK_3AA74CE6CB39D93A');
        $this->addSql('DROP TABLE alternatives');
        $this->addSql('DROP TABLE cells');
        $this->addSql('DROP TABLE characteristics');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE matrices');
        $this->addSql('DROP TABLE matrix_alternative');
        $this->addSql('DROP TABLE matrix_characteristic');
        $this->addSql('DROP TABLE results');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE task_alternative');
        $this->addSql('DROP TABLE task_characteristic');
        $this->addSql('DROP TABLE type_enums');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('DROP TABLE values');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
