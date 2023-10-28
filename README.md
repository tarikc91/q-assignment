## Requirements

1. <code>"php": "^8.1"</code>
2. Installed composer
3. Installed docker and docker-compose

## Setup process

1. Clone the repository
2. Run <code>composer install</code>
3. If using Docker => Run <code>./vendor/bin/sail up</code> and open <code>http://localhost</code>
4. If using local env => Run <code>php artisan serve</code> and open <code>http://127.0.0.1:8000</code>

## Commands
To create a new author using a command run <code>./vendor/bin/sail artisan qss:create-author</code> and follow the steps.
