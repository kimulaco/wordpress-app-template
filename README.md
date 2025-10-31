# wordpress-app-template

WordPress local development environment using Docker.

## Quick Start

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down
```

## Access URLs

- **WordPress**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8081

## Tech Stack

- WordPress 6.8.3
- PHP 8.4
- MySQL 8.0.23
- Docker Compose

## Development with DevContainer

This project includes VS Code DevContainer configuration.

1. Open in VS Code
2. Click "Reopen in Container" when prompted
3. Start developing with PHP CLI + WP-CLI + Composer

## Common Commands

```bash
# View logs
docker compose logs -f wordpress

# Access CLI container
docker compose exec cli bash

# Database backup
docker compose exec cli bash docker/db/scripts/dump.sh

# Database restore
docker compose exec cli bash docker/db/scripts/restore.sh docker/db/dumps/FILE.sql.gz
```

## Documentation

For detailed documentation, see [AGENT.md](./AGENT.md).
