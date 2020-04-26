<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417201340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE MATERIALIZED VIEW todo_materialized AS
            SELECT
                ROW_NUMBER() OVER(ORDER BY t.likes_count ) as row_num_all,
                ROW_NUMBER() OVER(partition BY t.status_id ORDER BY t.likes_count ) as row_num_by_status_id,
                t.id as todo_id, 
                t.status_id
            FROM todo AS t ORDER BY t.likes_count;
        ');
        $this->addSql('CREATE INDEX todo_materialized_row_num_all_index ON todo_materialized(row_num_all)');
        $this->addSql('CREATE INDEX todo_materialized_todo_id_index ON todo_materialized(todo_id)');
        $this->addSql('CREATE INDEX todo_materialized_row_num_by_status_id_index ON todo_materialized(row_num_by_status_id)');
        $this->addSql('CREATE INDEX todo_materialized_status_id_index ON todo_materialized(status_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP MATERIALIZED VIEW IF EXISTS todo_materialized CASCADE');
    }
}
