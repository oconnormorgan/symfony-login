#symfony-login

## Run server

`composer install`

`symfony serve`

## DATABASE
- PostgreSQL

### Copy .env to .env.local file and update :
DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"

### launch migration and fixture

`php bin/console doctrine:migrations:migrate`

`php bin/console doctrine:fixtures:load`

---

## With a Webservice REST

### login : 

`POST /login`

{ "email" : "admin@symfonylogin.fr", "password" : "password" }

### get information of user

`GET /user/{token}`

### logout

`DELETE /logout/{token}`



