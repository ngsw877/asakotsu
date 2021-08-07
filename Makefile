.PHONY: web
web:
	docker-compose exec web bash

.PHONY: app
app:
	docker-compose exec app bash

.PHONY: db
db:
	docker-compose exec db bash

.PHONY: format
format:
	docker-compose exec app ./vendor/bin/php-cs-fixer fix .

.PHONY: seed
seed:
	docker-compose exec app bash -c 'php artisan migrate:fresh --seed'
