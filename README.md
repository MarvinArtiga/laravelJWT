# API RESTful de Biblioteca

Proyecto API RESTful para gestionar una biblioteca (Laravel 12 + PostgreSQL + JWT).

## Tecnologías

- Laravel 12
- PHP
- PostgreSQL
- JWT (`tymon/jwt-auth`)
- Composer
- PHPUnit / Pest

## Requisitos

- PHP (compatible con Laravel 12)
- Composer
- PostgreSQL
- Node/npm (para frontend si es necesario)

## Instalación

```bash
git clone <REPOSITORY_URL>
cd biblioteca
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
# Configure PostgreSQL (see .env)
php artisan migrate --seed
php artisan serve
```

## Endpoints

Public:

- `POST /api/auth/register` — Register user
- `POST /api/auth/login` — Obtain JWT

Protected (require header `Authorization: Bearer <TOKEN>`):

- `POST /api/auth/logout` — Invalidate current token
- `GET  /api/auth/me` — Get authenticated user
- `GET    /api/books` — List books
- `GET    /api/books/{id}` — Get book
- `POST   /api/books` — Create book
- `PUT    /api/books/{id}` — Replace book
- `PATCH  /api/books/{id}` — Update book (partial)
- `DELETE /api/books/{id}` — Delete book

## Seguridad

- Passwords are hashed with Laravel's `Hash::make`.
- JWTs are stateless and not stored in DB.
- Do not commit `.env` or secrets.

## Tests

Run tests with:

```bash
php artisan test
```

Note: The test environment uses the PHP SQLite PDO driver by default. Ensure `pdo_sqlite` is available for running tests locally.

## Notas

- After installing `tymon/jwt-auth`, the `config/jwt.php` file is published and `JWT_SECRET` is added to `.env` when running `php artisan jwt:secret`.

