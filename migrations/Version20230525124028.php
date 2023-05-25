<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525124028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE alternatives_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE characteristic_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE characteristic_type_enum_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE characteristics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_alternative_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_cell_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_cell_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_characteristic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_condition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tasks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "users_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE alternatives (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN alternatives.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE characteristic_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, is_number BOOLEAN DEFAULT false NOT NULL, default_type BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE characteristic_type_enum (id INT NOT NULL, type_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F122F0DFC54C8C93 ON characteristic_type_enum (type_id)');
        $this->addSql('CREATE TABLE characteristics (id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, multiple BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7037B156C54C8C93 ON characteristics (type_id)');
        $this->addSql('CREATE TABLE matrix (id INT NOT NULL, task_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F83341CF8DB60186 ON matrix (task_id)');
        $this->addSql('CREATE TABLE matrix_alternative (id INT NOT NULL, matrix_id INT NOT NULL, alternative_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CB5E36F3AA000BE7 ON matrix_alternative (matrix_id)');
        $this->addSql('CREATE INDEX IDX_CB5E36F3FC05FFAC ON matrix_alternative (alternative_id)');
        $this->addSql('CREATE INDEX matrix_alternative_idx ON matrix_alternative (matrix_id, alternative_id)');
        $this->addSql('COMMENT ON COLUMN matrix_alternative.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE matrix_cell (id INT NOT NULL, alternative_id INT NOT NULL, characteristic_id INT NOT NULL, matrix_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_240787D7FC05FFAC ON matrix_cell (alternative_id)');
        $this->addSql('CREATE INDEX IDX_240787D7DEE9D12B ON matrix_cell (characteristic_id)');
        $this->addSql('CREATE INDEX IDX_240787D7AA000BE7 ON matrix_cell (matrix_id)');
        $this->addSql('CREATE INDEX matrix_alternative_characteristic_idx ON matrix_cell (matrix_id, alternative_id, characteristic_id)');
        $this->addSql('CREATE TABLE matrix_cell_value (id INT NOT NULL, matrix_cell_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_392122384217D8E ON matrix_cell_value (matrix_cell_id)');
        $this->addSql('CREATE TABLE matrix_characteristic (id INT NOT NULL, matrix_id INT NOT NULL, characteristic_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A26B308AA000BE7 ON matrix_characteristic (matrix_id)');
        $this->addSql('CREATE INDEX IDX_7A26B308DEE9D12B ON matrix_characteristic (characteristic_id)');
        $this->addSql('CREATE INDEX matrix_characteristic_idx ON matrix_characteristic (matrix_id, characteristic_id)');
        $this->addSql('COMMENT ON COLUMN matrix_characteristic.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE matrix_condition (id INT NOT NULL, matrix_id INT NOT NULL, characteristic_id INT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ECC44B16AA000BE7 ON matrix_condition (matrix_id)');
        $this->addSql('CREATE INDEX IDX_ECC44B16DEE9D12B ON matrix_condition (characteristic_id)');
        $this->addSql('CREATE TABLE tasks (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "users" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON "users" (username)');
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
        $this->addSql('ALTER TABLE characteristic_type_enum ADD CONSTRAINT FK_F122F0DFC54C8C93 FOREIGN KEY (type_id) REFERENCES characteristic_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characteristics ADD CONSTRAINT FK_7037B156C54C8C93 FOREIGN KEY (type_id) REFERENCES characteristic_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix ADD CONSTRAINT FK_F83341CF8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_alternative ADD CONSTRAINT FK_CB5E36F3AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_alternative ADD CONSTRAINT FK_CB5E36F3FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell ADD CONSTRAINT FK_240787D7FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell ADD CONSTRAINT FK_240787D7DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell ADD CONSTRAINT FK_240787D7AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell_value ADD CONSTRAINT FK_392122384217D8E FOREIGN KEY (matrix_cell_id) REFERENCES matrix_cell (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_characteristic ADD CONSTRAINT FK_7A26B308AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_characteristic ADD CONSTRAINT FK_7A26B308DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_condition ADD CONSTRAINT FK_ECC44B16AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_condition ADD CONSTRAINT FK_ECC44B16DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('DROP SEQUENCE alternatives_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE characteristic_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE characteristic_type_enum_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE characteristics_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_alternative_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_cell_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_cell_value_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_characteristic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_condition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tasks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "users_id_seq" CASCADE');
        $this->addSql('ALTER TABLE characteristic_type_enum DROP CONSTRAINT FK_F122F0DFC54C8C93');
        $this->addSql('ALTER TABLE characteristics DROP CONSTRAINT FK_7037B156C54C8C93');
        $this->addSql('ALTER TABLE matrix DROP CONSTRAINT FK_F83341CF8DB60186');
        $this->addSql('ALTER TABLE matrix_alternative DROP CONSTRAINT FK_CB5E36F3AA000BE7');
        $this->addSql('ALTER TABLE matrix_alternative DROP CONSTRAINT FK_CB5E36F3FC05FFAC');
        $this->addSql('ALTER TABLE matrix_cell DROP CONSTRAINT FK_240787D7FC05FFAC');
        $this->addSql('ALTER TABLE matrix_cell DROP CONSTRAINT FK_240787D7DEE9D12B');
        $this->addSql('ALTER TABLE matrix_cell DROP CONSTRAINT FK_240787D7AA000BE7');
        $this->addSql('ALTER TABLE matrix_cell_value DROP CONSTRAINT FK_392122384217D8E');
        $this->addSql('ALTER TABLE matrix_characteristic DROP CONSTRAINT FK_7A26B308AA000BE7');
        $this->addSql('ALTER TABLE matrix_characteristic DROP CONSTRAINT FK_7A26B308DEE9D12B');
        $this->addSql('ALTER TABLE matrix_condition DROP CONSTRAINT FK_ECC44B16AA000BE7');
        $this->addSql('ALTER TABLE matrix_condition DROP CONSTRAINT FK_ECC44B16DEE9D12B');
        $this->addSql('DROP TABLE alternatives');
        $this->addSql('DROP TABLE characteristic_type');
        $this->addSql('DROP TABLE characteristic_type_enum');
        $this->addSql('DROP TABLE characteristics');
        $this->addSql('DROP TABLE matrix');
        $this->addSql('DROP TABLE matrix_alternative');
        $this->addSql('DROP TABLE matrix_cell');
        $this->addSql('DROP TABLE matrix_cell_value');
        $this->addSql('DROP TABLE matrix_characteristic');
        $this->addSql('DROP TABLE matrix_condition');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
