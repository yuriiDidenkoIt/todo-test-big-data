<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330051954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE todo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TYPE enum_status AS ENUM (\'new\',\'rejected\', \'in_progress\', \'completed\');');
        $this->addSql('CREATE TABLE todo (id INT NOT NULL DEFAULT NEXTVAL(\'todo_id_seq\'), title VARCHAR(255) NOT NULL, status enum_status DEFAULT \'new\', likes_count INT DEFAULT 0, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX todo_status_created_at_likes_count ON todo(id,status,likes_count)');

    }


    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE todo_id_seq CASCADE');
        $this->addSql('DROP TABLE todo');
        $this->addSql('DROP TYPE enum_status');
    }
}
