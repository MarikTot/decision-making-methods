<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508094520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE matrices_id_seq CASCADE');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT fk_cd95a3befc05ffac');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT fk_cd95a3bedee9d12b');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT fk_cd95a3be8db60186');
        $this->addSql('DROP TABLE matrices');
        $this->addSql('DROP INDEX uniq_1483a5e9e7927c74');
        $this->addSql('ALTER TABLE users DROP is_verified');
        $this->addSql('ALTER TABLE users RENAME COLUMN email TO username');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('CREATE SEQUENCE matrices_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matrices (id INT NOT NULL, alternative_id INT NOT NULL, characteristic_id INT NOT NULL, task_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_cd95a3be8db60186 ON matrices (task_id)');
        $this->addSql('CREATE INDEX idx_cd95a3bedee9d12b ON matrices (characteristic_id)');
        $this->addSql('CREATE INDEX idx_cd95a3befc05ffac ON matrices (alternative_id)');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT fk_cd95a3befc05ffac FOREIGN KEY (alternative_id) REFERENCES alternatives (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT fk_cd95a3bedee9d12b FOREIGN KEY (characteristic_id) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT fk_cd95a3be8db60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX UNIQ_1483A5E9F85E0677');
        $this->addSql('ALTER TABLE "users" ADD is_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "users" RENAME COLUMN username TO email');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON "users" (email)');
    }
}
