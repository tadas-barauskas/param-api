# Param-api 

Project simulates filter option loading via API for products with attributes. 

## Installation

Project db and redis instances launched with docker-compose:
```bash
docker-compose up -d
```

Once containers are up and running launch the following from project directory:
```bash
composer install
php "bin/console" doctrine:schema:create
php "bin/console" doctrine:migrations:migrate
php "bin/console" doctrine:fixtures:load
```

This will prepare db with Article/Attribute entity and their relation tables, and populate those tables with fixture data.  

## Filter option publishing

Filter options are collected with following command and published to redis:
```bash
php bin/console app:publish-filters
```

## Redis

Redis cached values can be seen via redis-commander at `http://localhost:8081/`

## Parameter API 

There is a single API endpoint created
`GET https://127.0.0.1:8000/parameter`

To reach this endpoint run:
```bash
symfony server:start
```

Endpoint makes use of two parameters that can be added via query: `param1` and `param2`. If one of these is added to query, it would be treated as selected option and would filter out the other param with unavailable options.
If both params are passed an empty response is returned.  


## Testing

Tests can be launched with 
```bash
php bin/phpunit
```
