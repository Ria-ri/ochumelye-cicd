# CI/CD Pipeline для приложения Laravel

## Обзор

Пайплайн реализован с помощью **GitHub Actions** и выполняется при любом push или pull request в ветки `dev`, `uat`, `main`/`master`.

## Шаги пайплайна

1. **Checkout code** – загрузка кода репозитория.
2. **Setup PHP** – установка PHP 8.2 и необходимых расширений.
3. **Install dependencies** – установка Composer-пакетов.
4. **Environment preparation** – копирование `.env.ci` и генерация `APP_KEY`.
5. **Run migrations** – создание тестовой базы SQLite в памяти.
6. **Run tests with coverage** – выполнение PHPUnit, проверка покрытия кода (минимум 50%).
7. **Static analysis** – PHPStan (Larastan) на уровне 0. При любой ошибке пайплайн падает.
8. **Linting** – Laravel Pint с пресетом `laravel` (PSR-12). Только проверка, без автоисправления.
9. **Simulate deploy** – копирование соответствующего `.env` в зависимости от ветки:
   - `dev` → `.env.dev`
   - `uat` → `.env.uat`
   - `main`/`master` → `.env.prod`
10. **Manual approval (только для main/master)** – через GitHub Environments требуется ручное подтверждение.
11. **Notification** – отправка сообщения в Telegram (опционально).

## Переменные окружения

Файлы `.env.dev`, `.env.uat`, `.env.prod`, `.env.ci` хранятся в репозитории. Основной `.env` игнорируется.

## Как запустить локально

```bash
composer install
cp .env.ci .env
php artisan key:generate
php artisan migrate --force
php artisan test --coverage
./vendor/bin/phpstan analyse
./vendor/bin/pint --test