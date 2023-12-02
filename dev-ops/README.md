
# Setup for Symfony API and Angular Dockerized Project
Docker compose for symfony + mysql + angular

## **Prerequiests**
- Docker
- Docker Compose
- The ports used in the [docker-compose.yml](https://github.com/lboecker/GrammatikTestTiedemann/blob/master/dev-ops/docker-compose.yml) should be free.
- For developing on Angular I prefer to [ng-serve](https://github.com/angular/angular-cli/wiki/serve) on your machine. You don't really need to run docker-compose for each frontend changes.

## Docker containers:

		DataBase:
		 1. MySQL
		
		Server Code:
		 1. PHP
		 2. Nginx
	 
		 Frontend:
		 1. NGINX


Usage
-----
Run development environment
```bash
$ docker-compose up
```
or run in background
```bash
$ docker-compose up -d
```
To down environment
```bash
$ docker-compose down
```
Useful
------
Show all container
```bash
$ docker-compose ps
```
Connect to container
```bash
$ docker exec -it {container_name} bash
```
Restart an service
```bash
$ docker-compose restart {container_name}
```

Hacks
-----
Possible headaches when running docker-compose for the first time:

```
An exception occurred while executing a query: SQLSTATE[42S02]: Base table or view not found: Table 'database.TABLE' doesn't exist
```
Solution

```
docker exec -it grammerjourney_php sh
php bin/console doctrine:schema:update --force
```

Access to projects
------------------
Symfony: http://127.0.0.1:8080 

Angular: http://127.0.0.1:8081
