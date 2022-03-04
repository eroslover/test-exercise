# Test Project

## Deploy

### Prerequisites

Make sure these dependencies are installed on you machine

- [Docker](https://www.docker.com/ "Docker")
- [Docker compose](https://docs.docker.com/compose/ "Docker compose")

### Start LOCAL environment

Firstly you need to create `.env` file in both folders - root and project. You can use `.env.example` from corresponding folder as prototype of your `.env` file:

``` bash
$ cp .env.example .env
```

Then you need to create `docker-compose.local.yml` file. You can use `docker-compose.yml` as prototype:

``` bash
$ cp docker-compose.yml docker-compose.local.yml
```

To run LOCAL environment execute following command from the root of the project:

 ``` bash
 $ docker-compose -f docker-compose.local.yml up -d
 ```

To enter into `php-fpm` container for running composer or artisan commands, execute the following command from the root of the project:

 ``` bash
 $ docker-compose -f docker-compose.local.yml exec --user www-data php-fpm bash
 ```

If there is no previously built images then docker will take from 10 to 20 minutes to download and build images.
Then it will start containers.
To verify that containers were started correctly run:

 ``` bash
 $ docker-compose -f docker-compose.local.yml ps
 ```

After containers successfully ran, composer and node must install dependencies.
It will take about 5 min
To view installation progress you can use  next command:

 ``` bash
 $ docker-compose -f docker-compose.local.yml logs
 ```

### Running tests

You need to enter `postgres` container and create `testing` database within the container.

1. Enter `postgres` container: `docker-compose -f docker-compose.run.yml exec postgres bash`
2. Inside `postgres` container log in into postgres `psql -Uadmin test_project`
3. Create `testing` database - `CREATE DATABASE testing;`
4. Exit from `postgres` container, go to the project folder and run `./test.sh`

### Тестовое задание

#### Реализовать многопользовательский REST API сервис для формирования подборки задач по программированию на каждый день.

Категории задач:
1. Fundamentals
2. String
3. Algorithms
4. Mathematic
5. Performance
6. Booleans
7. Functions

Задача может принадлежать только одной категории. Раз в сутки для каждого пользователя формируется уникальная подборка без повторений.

API–методы:
1. Регистрация/авторизация пользователя;
2. Метод получения подборки заданий для пользователя. Задание должно относиться к одной категории. В полученном списке должно быть понятно какие задачи выполнены, а какие еще нет;
3. Метод для пометки задачи как выполненное;
4. Метод замены задания на другое (например, если задание неинтересно);

Требования:
1. Язык: PHP (лучше версии PHP8);
2. БД: произвольная реляционная;
3. Фреймворк: лучше Laravel, но если не знаешь, то любой другой;
4. Стандарты: PSR;

Результат:
1.  ссылка на git-репозиторий с исходниками проекта;

