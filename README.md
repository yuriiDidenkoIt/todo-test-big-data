# Todo test

My test example of todo list with more 3 million data (don't have  time to make 10 million  and beautiful css)
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

pg_restore -d todo_test todo_test.tar  -c -U your_root_user_name

symfony server:start
 ```

## Go to http://127.0.0.1:8000 

## License
[MIT](https://choosealicense.com/licenses/mit/)