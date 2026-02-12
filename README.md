# Slim + MySQL + Meilisearch (Docker)

Example project with:
- PHP Slim Framework API
- MySQL `products` table (multilanguage + dynamic metadata)
- Meilisearch integration
- Docker Compose setup
- Structured bootstrap/config + handlers/services/repositories

## Run

```bash
docker compose down -v

docker compose up --build
```

App runs on `http://localhost:8080`.

## Project Structure

```text
config/
  bootstrap.php
  commands.php
  dependencies.php
  config.php
  routes.php

src/
  Domain/
  Handler/
  Service/
  Repository/
```

## Libraries

- `symfony/console`
- `symfony/dotenv`
- `nyholm/psr7`
- `nyholm/psr7-server`
- `monolog/monolog`

## CLI

```bash
docker compose exec -T app php bin/console app:reindex
```

## Product Data Model

`products` includes:
- `sku`
- `product_type`
- `name` (JSON translations, e.g. `en`, `it`)
- `description` (JSON translations)
- `metadata` (JSON, dynamic + multilingual by product type: `color.en/color.it`, `material.en/material.it`, `size.en/size.it`, `weight.en/weight.it`, etc.)
- `price`

Dedicated metadata mapping table:
- `product_metadata_fields`
- associates metadata keys to each `product_type`
- includes multilingual labels, value type, required flag, and order

## API Endpoints

1. Health check
```bash
curl http://localhost:8080/health
```

2. Read products (language + type filter)
```bash
curl "http://localhost:8080/products?lang=it"
curl "http://localhost:8080/products?lang=en&type=apparel"
```

Response includes:
- `metadata`: localized values for selected `lang` (fallback to `en`)
- `metadata_translations`: full multilingual metadata object

3. Reindex MySQL products to Meilisearch
```bash
curl -X POST http://localhost:8080/reindex
```

4. Read metadata fields by product type
```bash
curl "http://localhost:8080/metadata-fields?lang=it&type=footwear"
curl "http://localhost:8080/metadata-fields?lang=en"
```

5. Build filters from metadata fields + product values
```bash
curl "http://localhost:8080/filters?lang=it&type=footwear"
curl "http://localhost:8080/filters?lang=en&type=electronics"
```

6. Search in Meilisearch (optional type filter)
```bash
curl "http://localhost:8080/search?q=laptop"
curl "http://localhost:8080/search?q=cotone&type=apparel"
```

## Notes

- Seed SQL is in `docker/mysql/init.sql`.
- Reindex once after startup (`POST /reindex`) before calling search.

## Database Migrations & Seeds (Phinx)

Phinx is configured with:
- `phinx.php`
- `db/migrations`
- `db/seeds`

Commands:
```bash
make phinx-version
make phinx-status
make phinx-rollback
make phinx-migrate
make phinx-seed
```

Direct usage:
```bash
docker compose exec -T app ./vendor/bin/phinx status -c phinx.php
docker compose exec -T app ./vendor/bin/phinx migrate -c phinx.php
docker compose exec -T app ./vendor/bin/phinx seed:run -c phinx.php
```
