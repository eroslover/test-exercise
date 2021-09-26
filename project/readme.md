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
2. Create `testing` database - `CREATE DATABASE testing;`
3. Exit from `postgres` container, go to the project folder and run `./test.sh`
