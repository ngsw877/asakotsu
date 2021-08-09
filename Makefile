.PHONY: web
web: # webコンテナに入る
	docker-compose exec web bash

.PHONY: app
app: # appコンテナに入る
	docker-compose exec app bash

.PHONY: db
db: # dbコンテナに入る
	docker-compose exec db bash

.PHONY: format
format: # PHP-CS-FixerでPHPコードを整形する
	docker-compose exec app ./vendor/bin/php-cs-fixer fix .

.PHONY: seed
seed: # DBをリセットし、Seedingする
	docker-compose exec app bash -c 'php artisan migrate:fresh --seed'

