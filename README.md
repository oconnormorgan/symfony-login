#symfony-login

### Run server
- Symfony serve

###Copy .env to .env.local file and update :
- DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"


- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load
