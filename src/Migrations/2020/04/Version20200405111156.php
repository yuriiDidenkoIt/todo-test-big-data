<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405111156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('DROP TRIGGER IF EXISTS todo_count_trunc on todo');
        $this->addSql('DROP TRIGGER IF EXISTS todo_count_mod on todo');
        $this->addSql('DROP FUNCTION IF EXISTS todo_count()');
        $this->addSql('DROP TABLE IF EXISTS todo_count');
        $this->addSql('DROP INDEX IF EXISTS todo_status_created_at_likes_count');

        $this->addSql('ALTER TABLE todo ADD COLUMN IF NOT EXISTS status_id SMALLINT');
        $this->addSql('CREATE INDEX IF NOT EXISTS likes_count_index ON todo(likes_count)');
        $this->addSql('CREATE INDEX IF NOT EXISTS status_id_index ON todo(status_id)');
        $this->addSql('ALTER TABLE todo DROP COLUMN IF EXISTS status');
        $this->addSql('DROP TYPE IF EXISTS enum_status CASCADE');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
