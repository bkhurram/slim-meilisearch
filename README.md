# Slim + MySQL + Meilisearch (Docker)

Example project with:
- PHP Slim Framework API
- MySQL `products` table (multilingual + dynamic metadata)
- Dedicated metadata fields mapping table by product type
- Meilisearch integration with custom synonyms
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
  middleware.php

src/
  Domain/
  Handler/
  Service/
  Repository/
  Command/

database/
  migrations/
  seeds/
```

## Libraries

- `symfony/console`
- `symfony/dotenv`
- `nyholm/psr7`
- `nyholm/psr7-server`
- `monolog/monolog`
- `robmorgan/phinx`

## API Endpoints

All endpoints are under `/api`.

1. Health check
```bash
curl http://localhost:8080/api/health
```

2. Read products (language + type filter)
```bash
curl "http://localhost:8080/api/products?lang=it"
curl "http://localhost:8080/api/products?lang=en&type=apparel"
```

3. Reindex MySQL products to Meilisearch
```bash
curl -X POST http://localhost:8080/api/reindex
```

4. Read metadata fields by product type
```bash
curl "http://localhost:8080/api/metadata-fields?lang=it&type=footwear"
curl "http://localhost:8080/api/metadata-fields?lang=en"
```

5. Build dynamic filters from metadata fields + product values
```bash
curl "http://localhost:8080/api/products-filters?lang=it&type=footwear"
curl "http://localhost:8080/api/products-filters?lang=en&type=electronics"
```

6. Search in Meilisearch (optional type filter)
```bash
curl "http://localhost:8080/api/products-search?q=laptop"
curl "http://localhost:8080/api/products-search?q=cotone&type=apparel"
```

## CLI Commands

Use the project console entrypoint:

```bash
docker compose exec -T app php console app:product-reindex
docker compose exec -T app php console app:meilisearch-task --uid=1
```

## Product Data Model

`products` includes:
- `sku`
- `product_type`
- `name` (JSON translations, e.g. `en`, `it`)
- `description` (JSON translations)
- `metadata` (JSON, dynamic + multilingual by product type)
- `price`

`product_metadata_fields`:
- associates metadata keys to each `product_type`
- includes multilingual labels (`label` JSON), value type, required flag and sort order

## Database Migrations & Seeds (Phinx)

Phinx configuration:
- `phinx.php`
- `database/migrations`
- `database/seeds`

Migrations are split by table:
- `20260212000100_create_products_table.php`
- `20260212000200_create_product_metadata_fields_table.php`

Rollback behavior:
- each migration defines explicit `down()` and drops its table on rollback

Make targets:
```bash
make phinx-version
make phinx-status
make phinx-migrate
make phinx-seed
make phinx-rollback
```

Direct usage:
```bash
docker compose exec -T app ./vendor/bin/phinx status -c phinx.php
docker compose exec -T app ./vendor/bin/phinx migrate -c phinx.php
docker compose exec -T app ./vendor/bin/phinx seed:run -c phinx.php
docker compose exec -T app ./vendor/bin/phinx rollback -t 0 -c phinx.php
```

## HTTP Requests File

Ready-to-run examples are available in:
- `request.http`
