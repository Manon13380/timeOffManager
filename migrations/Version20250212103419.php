<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212103419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leave_request DROP CONSTRAINT fk_7dc8f7789d86650f');
        $this->addSql('DROP INDEX idx_7dc8f7789d86650f');
        $this->addSql('ALTER TABLE leave_request RENAME COLUMN user_id_id TO user_name_id');
        $this->addSql('ALTER TABLE leave_request ADD CONSTRAINT FK_7DC8F778291A82DC FOREIGN KEY (user_name_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7DC8F778291A82DC ON leave_request (user_name_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE leave_request DROP CONSTRAINT FK_7DC8F778291A82DC');
        $this->addSql('DROP INDEX IDX_7DC8F778291A82DC');
        $this->addSql('ALTER TABLE leave_request RENAME COLUMN user_name_id TO user_id_id');
        $this->addSql('ALTER TABLE leave_request ADD CONSTRAINT fk_7dc8f7789d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7dc8f7789d86650f ON leave_request (user_id_id)');
    }
}
