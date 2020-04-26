<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\DataObject\Status;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405125605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE TABLE IF NOT EXISTS todo_count(all_items bigint DEFAULT 0,new_items bigint DEFAULT 0,rejected_items bigint DEFAULT 0,in_progress_items bigint DEFAULT 0, completed_items bigint DEFAULT 0)');
        $this->addSql('INSERT INTO todo_count(all_items,new_items,rejected_items,in_progress_items) VALUES (0,0,0,0)');
        $this->addSql('CREATE FUNCTION todo_count() RETURNS trigger
                           LANGUAGE plpgsql AS
                        $$BEGIN
                           IF TG_OP = \'INSERT\' THEN
                              IF NEW.status_id=' . Status::ID_NEW . ' THEN
                                UPDATE todo_count SET all_items = all_items + 1, new_items = new_items + 1;

                                RETURN NEW;
                              ELSIF NEW.status_id=' . Status::ID_COMPLETED . ' THEN
                                UPDATE todo_count SET all_items = all_items + 1, completed_items = completed_items + 1;

                                RETURN NEW;
                              ELSIF NEW.status_id=' . Status::ID_REJECTED . ' THEN
                                UPDATE todo_count SET all_items = all_items + 1, rejected_items = rejected_items + 1;

                                RETURN NEW;
                              ELSIF NEW.status_id=' . Status::ID_IN_PROGRESS . ' THEN
                                UPDATE todo_count SET all_items = all_items + 1, in_progress_items = in_progress_items + 1;

                                RETURN NEW;
                              ELSE
                                RETURN NEW;

                              END IF;

                              RETURN NEW;
                           ELSIF TG_OP = \'UPDATE\' THEN
                              IF NEW.status_id=' . Status::ID_NEW . ' AND OLD.status_id=' . Status::ID_COMPLETED . ' THEN
                                UPDATE todo_count SET new_items = new_items + 1, completed_items = completed_items - 1;

                                RETURN NEW;

                              ELSIF NEW.status_id=' . Status::ID_COMPLETED . ' AND OLD.status_id=' . Status::ID_NEW . ' THEN
                                UPDATE todo_count SET completed_items = completed_items + 1, new_items = new_items - 1;

                                RETURN NEW;

                              ELSIF NEW.status_id=' . Status::ID_COMPLETED . ' AND OLD.status_id=' . Status::ID_REJECTED . ' THEN
                                UPDATE todo_count SET completed_items = completed_items + 1, rejected_items = rejected_items - 1;

                                RETURN NEW;

                              ELSIF NEW.status_id=' . Status::ID_COMPLETED . ' AND OLD.status_id=' . Status::ID_IN_PROGRESS . ' THEN
                                UPDATE todo_count SET completed_items = completed_items + 1, in_progress_items = in_progress_items - 1;

                                RETURN NEW;

                              ELSE
                                RETURN NEW;

                              END IF;

                           ELSIF TG_OP = \'DELETE\' THEN
                              IF OLD.status_id=' . Status::ID_NEW . ' THEN
                                UPDATE todo_count SET all_items = all_items - 1, new_items = new_items - 1;

                                RETURN OLD;
                              ELSIF OLD.status_id=' . Status::ID_COMPLETED . ' THEN
                                UPDATE todo_count SET all_items = all_items - 1, completed_items = completed_items - 1;

                                RETURN OLD;
                              ELSIF OLD.status_id=' . Status::ID_REJECTED . ' THEN
                                UPDATE todo_count SET all_items = all_items - 1, rejected_items = rejected_items - 1;

                                RETURN OLD;
                              ELSIF OLD.status_id=' . Status::ID_IN_PROGRESS . ' THEN
                                UPDATE todo_count SET all_items = all_items - 1, in_progress_items = in_progress_items - 1;

                                RETURN OLD;
                              ELSE
                                RETURN OLD;

                              END IF;
                           ELSE
                              UPDATE todo_count SET all_items = 0, new_items = 0, completed_items = 0, rejected_items = 0, in_progress_items = 0;

                              RETURN NULL;
                           END IF;
                        END;$$');

        $this->addSql('CREATE CONSTRAINT TRIGGER todo_count_mod
                           AFTER INSERT OR UPDATE OR DELETE ON todo
                           DEFERRABLE INITIALLY DEFERRED
                           FOR EACH ROW EXECUTE PROCEDURE todo_count()');
        $this->addSql('CREATE TRIGGER todo_count_trunc AFTER TRUNCATE ON todo
                           FOR EACH STATEMENT EXECUTE PROCEDURE todo_count()');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TRIGGER IF EXISTS todo_count_trunc on todo');
        $this->addSql('DROP TRIGGER IF EXISTS todo_count_mod on todo');
        $this->addSql('DROP FUNCTION IF EXISTS todo_count()');
        $this->addSql('DROP TABLE IF EXISTS todo_count');
    }
}
