# Laravel Claude Toolkit

Laravel 12 project with Docker-based development environment.

## Requirements

- Docker & Docker Compose

## Quick Start

```bash
./dev start        # Start development environment
./dev stop         # Stop all services
```

Access: http://localhost:8080

## Available Commands

```bash
./dev start        # Start dev environment with hot-reload
./dev stop         # Stop all services
./dev build        # Build production image
./dev shell        # Open shell in app container
./dev test         # Run PHPUnit tests
./dev artisan ...  # Run artisan commands
./dev composer ... # Run composer commands
./dev npm ...      # Run npm commands
./dev logs         # Follow container logs
./dev fresh        # Reset database and reseed
```

## Stack

- PHP 8.4 (FPM Alpine)
- Laravel 12
- SQLite
- Nginx
- Vite + Tailwind CSS 4
