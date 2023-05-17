<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508100233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE matrix_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_cell_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_cell_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matrix_condition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matrix (id INT NOT NULL, task_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F83341CF8DB60186 ON matrix (task_id)');
        $this->addSql('CREATE TABLE matrix_alternative (matrix_id INT NOT NULL, alternative_id INT NOT NULL, PRIMARY KEY(matrix_id, alternative_id))');
        $this->addSql('CREATE INDEX IDX_CB5E36F3AA000BE7 ON matrix_alternative (matrix_id)');
        $this->addSql('CREATE INDEX IDX_CB5E36F3FC05FFAC ON matrix_alternative (alternative_id)');
        $this->addSql('CREATE TABLE matrix_characteristic (matrix_id INT NOT NULL, characteristic_id INT NOT NULL, PRIMARY KEY(matrix_id, characteristic_id))');
        $this->addSql('CREATE INDEX IDX_7A26B308AA000BE7 ON matrix_characteristic (matrix_id)');
        $this->addSql('CREATE INDEX IDX_7A26B308DEE9D12B ON matrix_characteristic (characteristic_id)');
        $this->addSql('CREATE TABLE matrix_cell (id INT NOT NULL, alternative_id INT NOT NULL, characteristic_id INT NOT NULL, matrix_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_240787D7FC05FFAC ON matrix_cell (alternative_id)');
        $this->addSql('CREATE INDEX IDX_240787D7DEE9D12B ON matrix_cell (characteristic_id)');
        $this->addSql('CREATE INDEX IDX_240787D7AA000BE7 ON matrix_cell (matrix_id)');
        $this->addSql('CREATE TABLE matrix_cell_value (id INT NOT NULL, matrix_cell_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_392122384217D8E ON matrix_cell_value (matrix_cell_id)');
        $this->addSql('CREATE TABLE matrix_condition (id INT NOT NULL, matrix_id INT NOT NULL, characteristic_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ECC44B16AA000BE7 ON matrix_condition (matrix_id)');
        $this->addSql('CREATE INDEX IDX_ECC44B16DEE9D12B ON matrix_condition (characteristic_id)');
        $this->addSql('ALTER TABLE matrix ADD CONSTRAINT FK_F83341CF8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_alternative ADD CONSTRAINT FK_CB5E36F3AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_alternative ADD CONSTRAINT FK_CB5E36F3FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_characteristic ADD CONSTRAINT FK_7A26B308AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_characteristic ADD CONSTRAINT FK_7A26B308DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell ADD CONSTRAINT FK_240787D7FC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell ADD CONSTRAINT FK_240787D7DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell ADD CONSTRAINT FK_240787D7AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_cell_value ADD CONSTRAINT FK_392122384217D8E FOREIGN KEY (matrix_cell_id) REFERENCES matrix_cell (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_condition ADD CONSTRAINT FK_ECC44B16AA000BE7 FOREIGN KEY (matrix_id) REFERENCES matrix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrix_condition ADD CONSTRAINT FK_ECC44B16DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('DROP SEQUENCE matrix_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_cell_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_cell_value_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matrix_condition_id_seq CASCADE');
        $this->addSql('ALTER TABLE matrix DROP CONSTRAINT FK_F83341CF8DB60186');
        $this->addSql('ALTER TABLE matrix_alternative DROP CONSTRAINT FK_CB5E36F3AA000BE7');
        $this->addSql('ALTER TABLE matrix_alternative DROP CONSTRAINT FK_CB5E36F3FC05FFAC');
        $this->addSql('ALTER TABLE matrix_characteristic DROP CONSTRAINT FK_7A26B308AA000BE7');
        $this->addSql('ALTER TABLE matrix_characteristic DROP CONSTRAINT FK_7A26B308DEE9D12B');
        $this->addSql('ALTER TABLE matrix_cell DROP CONSTRAINT FK_240787D7FC05FFAC');
        $this->addSql('ALTER TABLE matrix_cell DROP CONSTRAINT FK_240787D7DEE9D12B');
        $this->addSql('ALTER TABLE matrix_cell DROP CONSTRAINT FK_240787D7AA000BE7');
        $this->addSql('ALTER TABLE matrix_cell_value DROP CONSTRAINT FK_392122384217D8E');
        $this->addSql('ALTER TABLE matrix_condition DROP CONSTRAINT FK_ECC44B16AA000BE7');
        $this->addSql('ALTER TABLE matrix_condition DROP CONSTRAINT FK_ECC44B16DEE9D12B');
        $this->addSql('DROP TABLE matrix');
        $this->addSql('DROP TABLE matrix_alternative');
        $this->addSql('DROP TABLE matrix_characteristic');
        $this->addSql('DROP TABLE matrix_cell');
        $this->addSql('DROP TABLE matrix_cell_value');
        $this->addSql('DROP TABLE matrix_condition');
    }
}
