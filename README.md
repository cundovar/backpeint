# Backpeint API

This repository contains a Symfony 5.4 application powered by [API Platform](https://api-platform.com/). It exposes a REST API and includes tooling for database migrations and testing.

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd backpeint
   ```
2. **Install PHP dependencies**
   ```bash
   composer install
   ```
3. **Configure the environment**
   Copy `.env` to `.env.local` and adjust values such as `DATABASE_URL` for your database server.
4. **Start supporting services** (database, mail catcher, etc.)
   ```bash
   docker-compose up -d
   ```
5. **Run database migrations**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

## Environment Configuration

Environment variables are loaded from `.env` files. Create a `.env.local` file for machine‑specific overrides and ensure that `DATABASE_URL` points to your database. For testing, values in `.env.test` are used automatically.

## Common Commands

| Command | Description |
| ------- | ----------- |
| `symfony serve` or `php -S 127.0.0.1:8000 -t public` | Start the development web server. |
| `php bin/console doctrine:migrations:migrate` | Apply database migrations. |
| `php bin/console cache:clear` | Clear the application cache. |
| `docker-compose up -d` | Launch local infrastructure containers. |

## API Documentation

API Platform generates interactive documentation at [http://localhost:8000/api](http://localhost:8000/api). Refer to the [API Platform docs](https://api-platform.com/docs/) for framework usage details.

## Testing

Run the test suite with:

```bash
php bin/phpunit
```

Testing uses the configuration from `.env.test`.

