<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618080048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alternatives ADD created_by INT NOT NULL');
        $this->addSql('ALTER TABLE alternatives ADD CONSTRAINT FK_46682B54DE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_46682B54DE12AB56 ON alternatives (created_by)');
        $this->addSql('ALTER TABLE characteristics ADD created_by INT NOT NULL');
        $this->addSql('ALTER TABLE characteristics ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN characteristics.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE characteristics ADD CONSTRAINT FK_7037B156DE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7037B156DE12AB56 ON characteristics (created_by)');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT fk_cd95a3beb03a8386');
        $this->addSql('DROP INDEX idx_cd95a3beb03a8386');
        $this->addSql('ALTER TABLE matrices ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE matrices RENAME COLUMN created_by_id TO created_by');
        $this->addSql('COMMENT ON COLUMN matrices.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT FK_CD95A3BEDE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CD95A3BEDE12AB56 ON matrices (created_by)');
        $this->addSql('ALTER TABLE results DROP CONSTRAINT fk_9fa3e414b03a8386');
        $this->addSql('DROP INDEX idx_9fa3e414b03a8386');
        $this->addSql('ALTER TABLE results RENAME COLUMN created_by_id TO created_by');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E414DE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9FA3E414DE12AB56 ON results (created_by)');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT fk_50586597b03a8386');
        $this->addSql('DROP INDEX idx_50586597b03a8386');
        $this->addSql('ALTER TABLE tasks ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN created_by_id TO created_by');
        $this->addSql('COMMENT ON COLUMN tasks.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597DE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_50586597DE12AB56 ON tasks (created_by)');
        $this->addSql('ALTER TABLE type_enums ADD created_by INT NOT NULL');
        $this->addSql('ALTER TABLE type_enums ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN type_enums.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE type_enums ADD CONSTRAINT FK_9609730DE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9609730DE12AB56 ON type_enums (created_by)');
        $this->addSql('ALTER TABLE types ADD created_by INT NOT NULL');
        $this->addSql('ALTER TABLE types ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN types.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE types ADD CONSTRAINT FK_59308930DE12AB56 FOREIGN KEY (created_by) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_59308930DE12AB56 ON types (created_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results DROP CONSTRAINT FK_9FA3E414DE12AB56');
        $this->addSql('DROP INDEX IDX_9FA3E414DE12AB56');
        $this->addSql('ALTER TABLE results RENAME COLUMN created_by TO created_by_id');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT fk_9fa3e414b03a8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9fa3e414b03a8386 ON results (created_by_id)');
        $this->addSql('ALTER TABLE matrices DROP CONSTRAINT FK_CD95A3BEDE12AB56');
        $this->addSql('DROP INDEX IDX_CD95A3BEDE12AB56');
        $this->addSql('ALTER TABLE matrices DROP created_at');
        $this->addSql('ALTER TABLE matrices RENAME COLUMN created_by TO created_by_id');
        $this->addSql('ALTER TABLE matrices ADD CONSTRAINT fk_cd95a3beb03a8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_cd95a3beb03a8386 ON matrices (created_by_id)');
        $this->addSql('ALTER TABLE type_enums DROP CONSTRAINT FK_9609730DE12AB56');
        $this->addSql('DROP INDEX IDX_9609730DE12AB56');
        $this->addSql('ALTER TABLE type_enums DROP created_by');
        $this->addSql('ALTER TABLE type_enums DROP created_at');
        $this->addSql('ALTER TABLE alternatives DROP CONSTRAINT FK_46682B54DE12AB56');
        $this->addSql('DROP INDEX IDX_46682B54DE12AB56');
        $this->addSql('ALTER TABLE alternatives DROP created_by');
        $this->addSql('ALTER TABLE characteristics DROP CONSTRAINT FK_7037B156DE12AB56');
        $this->addSql('DROP INDEX IDX_7037B156DE12AB56');
        $this->addSql('ALTER TABLE characteristics DROP created_by');
        $this->addSql('ALTER TABLE characteristics DROP created_at');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597DE12AB56');
        $this->addSql('DROP INDEX IDX_50586597DE12AB56');
        $this->addSql('ALTER TABLE tasks DROP created_at');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN created_by TO created_by_id');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT fk_50586597b03a8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_50586597b03a8386 ON tasks (created_by_id)');
        $this->addSql('ALTER TABLE types DROP CONSTRAINT FK_59308930DE12AB56');
        $this->addSql('DROP INDEX IDX_59308930DE12AB56');
        $this->addSql('ALTER TABLE types DROP created_by');
        $this->addSql('ALTER TABLE types DROP created_at');
    }
}
