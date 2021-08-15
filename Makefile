.PHONY: web
web:
	docker-compose exec web bash

.PHONY: app
app:
	docker-compose exec app bash

.PHONY: db
db:
	docker-compose exec db bash

.PHONY: minio
minio:
	docker-compose exec minio bash

.PHONY: format
format:
	docker-compose exec app ./vendor/bin/php-cs-fixer fix .

.PHONY: seed
seed:
	docker-compose exec app bash -c 'php artisan migrate:fresh --seed'

.PHONY: init
init:
	docker-compose up -d --build
	cp .env.example .env
	cp laravel/.env.example laravel/.env

	docker-compose exec app composer install
	@make migrate
	docker-compose exec app php artisan db:seed
	docker-compose exec app npm install
	docker-compose exec app npm run dev
	docker-compose exec app php artisan key:generate

.PHONY: migrate
migrate:
	docker-compose exec app php artisan migrate

.PHONY: test
test:
	docker-compose exec app vendor/bin/phpunit


