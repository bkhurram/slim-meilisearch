up:
	docker compose up -d

down:
	docker compose down

ssh:
	docker compose exec -it app bash

phinx-version:
	docker compose exec -T app ./vendor/bin/phinx --version -c phinx.php

phinx-status:
	docker compose exec -T app ./vendor/bin/phinx status -c phinx.php

phinx-rollback:
	docker compose exec -T app ./vendor/bin/phinx rollback -t 0 -c phinx.php

phinx-migrate:
	docker compose exec -T app ./vendor/bin/phinx migrate -c phinx.php

phinx-seed:
	docker compose exec -T app ./vendor/bin/phinx seed:run -c phinx.php

test:
	./vendor/bin/phpunit --verbose tests

lint:
	docker-compose run --rm app bash -c "./vendor/bin/php-cs-fixer fix"

lint-affect:
	docker-compose run --rm app bash -c "./vendor/bin/php-cs-fixer fix -vvv --show-progress=dots --dry-run"
