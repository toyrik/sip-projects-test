up: docker-up
down: docker-down
init: docker-down-clear docker-pull docker-build docker-up app-init mysql-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-init:
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli chown root:www-data -R storage/
	docker-compose run --rm php-cli chmod 775 -R storage/
	docker-compose run --rm php-cli cp .env.docker .env
