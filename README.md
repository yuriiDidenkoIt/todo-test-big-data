# Todo test
My test example of todo list with more 3 million data (don't have  time to make 10 million and beautiful css)
At this time Have just performance of sorting and pagination. In future will try to optimize with updating data .
I'm using materialized view table for optimizations . There is saving row numbers ordered by likes_count and statuses.
It helps to get needed ids per page without using offset and limit because there is rownumbers in materilized table.
To understand what I mean just try to run this query.
```sql
SELECT
 ROW_NUMBER() OVER(ORDER BY t.likes_count ) as row_num_all,
 ROW_NUMBER() OVER(partition BY t.status_id ORDER BY t.likes_count ) as row_num_by_status_id,
 t.id as todo_id, 
 t.status_id
FROM todo AS t ORDER BY t.likes_count
```
## Installation

 - Install PHP 7.2.5 or higher and these PHP extensions 
(which are installed and enabled by default in most PHP7 installations): 
Ctype, iconv, JSON, PCRE, Session, SimpleX

 - Install Composer.
 
 - Install Symfony 

```bash
curl -sS https://get.symfony.com/cli/installer | bash
```

 - Install Postgres
 
 ```bash
brew install postgres
 ```

 - Run Postgres

 ```bash
pg_ctl -D /usr/local/var/postgres start
 ```
 - Go to root directory of the projects
 - Inside of the root directory in file .etc change 
 DATABASE_URL to 
 DATABASE_URL=postgresql://user_root:user_password@127.0.0.1:5432/todo_test
 
 Where user_name your root user and password your root password.
 
 - In root directory of project run in terminal :
 
 ```bash
composer install

npm install

yarn encore production

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate

symfony server:start
 ```
## Information about db dump
If you need db dump with 4 million items to test performance just send letter to yurii.didenko.it@gmail.com
and then you can do: 
```bash
pg_restore -d todo_test path/to/dump/todo_test.tar  -c -U your_root_user_name
```
## Go to http://127.0.0.1:8000 

## License
[MIT](https://choosealicense.com/licenses/mit/)