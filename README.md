# Laravel Claude Toolkit

Laravel 12 project with Docker-based development environment.

## Requirements

- Docker & Docker Compose

## Quick Start

```bash
./vendor/bin/sail up -d    # Start development environment
./vendor/bin/sail down     # Stop all services
```

Access: http://localhost:8083

## Available Commands

```bash
./vendor/bin/sail up -d      # Start dev environment
./vendor/bin/sail down       # Stop all services
./vendor/bin/sail shell      # Open shell in app container
./vendor/bin/sail test       # Run PHPUnit tests
./vendor/bin/sail artisan    # Run artisan commands
./vendor/bin/sail composer   # Run composer commands
./vendor/bin/sail npm        # Run npm commands
```

Tip: Add alias to your shell: `alias sail='./vendor/bin/sail'`

## Stack

- PHP 8.4
- Laravel 12
- SQLite
- Vite + Tailwind CSS 4

## License

MIT
