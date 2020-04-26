<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425095922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE FUNCTION todo_materialized() RETURNS trigger
                           LANGUAGE plpgsql AS
                        $$BEGIN
                           IF TG_OP = \'INSERT\' THEN
                              REFRESH MATERIALIZED VIEW todo_materialized;
                               
                              RETURN NEW;
                           ELSIF TG_OP = \'UPDATE\' THEN
                              IF NEW.status_id=OLD.status_id THEN
                                RETURN NEW;
                              ELSE
                                REFRESH MATERIALIZED VIEW todo_materialized;
                                
                                RETURN NEW;
                              END IF;

                           ELSIF TG_OP = \'DELETE\' THEN
                              REFRESH MATERIALIZED VIEW todo_materialized;
                              
                              RETURN OLD;
                           ELSE
                              REFRESH MATERIALIZED VIEW todo_materialized;
                              RETURN NULL;
                           END IF;
                        END;$$');

        $this->addSql('CREATE CONSTRAINT TRIGGER todo_materialized_mod
                           AFTER INSERT OR UPDATE OR DELETE ON todo
                           DEFERRABLE INITIALLY DEFERRED
                           FOR EACH ROW EXECUTE PROCEDURE todo_materialized()');
        $this->addSql('CREATE TRIGGER todo_materialized_trunc AFTER TRUNCATE ON todo
                           FOR EACH STATEMENT EXECUTE PROCEDURE todo_materialized()');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TRIGGER IF EXISTS todo_materialized_trunc on todo');
        $this->addSql('DROP TRIGGER IF EXISTS todo_materialized_mod on todo');
        $this->addSql('DROP FUNCTION IF EXISTS todo_materialized()');
    }
}
