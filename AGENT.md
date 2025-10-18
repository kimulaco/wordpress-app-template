# AGENT.md

## 🗣️ Communication Language

**IMPORTANT: Always communicate in Japanese (日本語) in all chat interactions.**

This repository is a practice environment for assuming the operational maintenance and support of a customer's WordPress system.

---

## 🎯 Project Overview

This is a **WordPress local development environment using Docker**. It runs WordPress 6.8.3 with PHP 8.4 and MySQL 8.0.23, including phpMyAdmin for database management. Fully localized in Japanese for immediate WordPress development.

## 📋 Tech Stack

### Core Technologies
- **WordPress**: 6.8.3
- **PHP**: 8.4
- **MySQL**: 8.0.23
- **Docker Compose**: 3.8
- **phpMyAdmin**: latest

### Localization
- Japanese (ja) full support
- Complete Japanese translation files for WordPress core, admin, and network admin

## 🏗️ Architecture

### Docker Container Structure

```
┌─────────────────────────────────────────────┐
│  WordPress Container                        │
│  (wordpress:6.8.1-php8.4)                  │
│  Port: 8000 → 80                           │
│  Volume: ./wordpress:/var/www/html         │
└────────────────┬────────────────────────────┘
                 │
                 │ wordpress_network
                 ▼
┌─────────────────────────────────────────────┐
│  MySQL Container (db)                       │
│  (mysql:8.0.23)                            │
│  Database: wordpress_db                     │
│  Volume: ./docker/mysql/data               │
└────────────────┬────────────────────────────┘
                 │
     ┌───────────┼───────────┐
     │           │           │
     ▼           ▼           ▼
┌─────────┐ ┌─────────┐ ┌─────────────────┐
│phpMyAdmin │WordPress│ CLI (DevContainer)│
│Port: 8081│         │ PHP+WP-CLI+Git   │
└──────────┘         └─────────────────┘
```

### Directory Structure

```
wordpress-app-template/
├── .devcontainer/             # VS Code DevContainer configuration
│   ├── devcontainer.json      # DevContainer settings
│   └── setup.sh               # Post-create setup script
├── docker/
│   ├── cli/                   # DevContainer/CLI service
│   │   └── Dockerfile         # PHP 8.4 + WP-CLI + Composer image
│   ├── mysql/
│   │   ├── data/              # MySQL data files (persistent, ignored)
│   │   ├── dumps/             # Database dumps (ignored)
│   │   ├── scripts/           # Database management scripts
│   │   │   ├── dump.sh        # Create database dump
│   │   │   ├── restore.sh     # Restore database from dump
│   │   │   └── reset.sh       # Reset database
│   │   └── README.md          # Database management guide
│   └── wordpress/
│       └── php.ini            # Docker専用PHP設定（ログ出力設定）
├── wordpress/                 # WordPress root directory
│   ├── .user.ini              # 本番環境用PHP設定（FTPアップロード対象）
│   ├── wp-admin/              # Admin panel
│   ├── wp-includes/           # Core files (2,210+ files)
│   ├── wp-content/            # Customizable content
│   │   ├── themes/            # Themes
│   │   │   ├── twentytwentyfive/  # Twenty Twenty-Five v1.3
│   │   │   ├── twentytwentyfour/  # Twenty Twenty-Four
│   │   │   └── twentytwentythree/ # Twenty Twenty-Three
│   │   ├── plugins/           # Plugins
│   │   │   └── akismet/       # Akismet spam protection
│   │   ├── languages/         # Translation files
│   │   ├── uploads/           # User uploads (ignored)
│   │   └── upgrade/           # Upgrade directory (ignored)
│   ├── wp-config.php          # WordPress configuration
│   └── index.php              # Entry point
├── docker-compose.yml         # Docker configuration
├── .gitignore                 # Git exclusion settings
└── AGENT.md                   # This documentation
```

## 📋 PHP Configuration Files

### php.ini Files Overview

This repository contains two PHP configuration files:

#### 1. `docker/wordpress/php.ini` - Docker Only
- **Purpose**: Reproduce production environment in Docker
- **Mount Point**: `/usr/local/etc/php/php.ini` (inside WordPress container)
- **Deployment**: Do NOT upload to rental servers
- **Git Management**: ✅ Yes

#### 2. `wordpress/.user.ini` - Production Environment
- **Purpose**: Actual configuration deployed to rental servers
- **Deployment**: Upload via FTP (together with WordPress files)
- **Location**: Document root (e.g., `public_html/`)
- **Git Management**: ✅ Yes
- **Notes**:
  - Permission: 644
  - Reflection time: 5-10 minutes (depends on server)
  - Service-specific settings should be written here

### PHP Log Configuration

Common log settings in both files:

```ini
[PHP]
; Don't display errors on screen (security)
display_errors = Off

; Log errors to file
log_errors = On
error_log = error_log

; Timezone setting
date.timezone = Asia/Tokyo
```

### Mounting in docker-compose.yml

Mount `docker/wordpress/php.ini` to WordPress container:

```yaml
wordpress:
  volumes:
    - ./docker/wordpress/php.ini:/usr/local/etc/php/php.ini:ro
```

**Note**: Container restart required after configuration changes: `docker compose restart wordpress`

## 🔧 Configuration

### Docker Compose Settings

#### WordPress Service
```yaml
Image: wordpress:6.8.1-php8.4
Platform: linux/amd64
Port: 8000:80
Volume: ./wordpress:/var/www/html
```

**Environment Variables:**
- `WORDPRESS_DB_HOST`: db:3306
- `WORDPRESS_DB_USER`: wordpress_user
- `WORDPRESS_DB_PASSWORD`: wordpress_user_password
- `WORDPRESS_DB_NAME`: wordpress_db
- `WORDPRESS_TABLE_PREFIX`: wp_
- `WORDPRESS_DEBUG`: 1 (debug mode enabled)

#### MySQL Service
```yaml
Image: mysql:8.0.23
Platform: linux/amd64
Volume: ./docker/mysql/data:/var/lib/mysql
```

**Environment Variables:**
- `MYSQL_ROOT_PASSWORD`: root_password
- `MYSQL_DATABASE`: wordpress_db
- `MYSQL_USER`: wordpress_user
- `MYSQL_PASSWORD`: wordpress_user_password

#### phpMyAdmin Service
```yaml
Image: phpmyadmin/phpmyadmin:latest
Platform: linux/amd64
Port: 8081:80
```

#### CLI Service (DevContainer)
```yaml
Build: ./docker/cli/Dockerfile
Base Image: php:8.4-cli
Platform: linux/amd64
Volumes:
  - ./wordpress:/var/www/html
  - .:/workspace
Working Directory: /workspace
```

**Installed Tools:**
- PHP 8.4 CLI with extensions (mysqli, gd, zip, mbstring, xml, exif)
- WP-CLI
- Git
- MySQL client

**Use Cases:**
- VS Code DevContainer environment
- Manual CLI access: `docker-compose exec cli bash`
- WP-CLI commands: `docker-compose exec cli wp --allow-root`

### WordPress Configuration (wp-config.php)

Customized for Docker environment:
- Dynamic configuration from environment variables (`getenv_docker` function)
- Debug mode enabled
- Reverse proxy support
- Pre-configured authentication keys and salts (must change for production)

## 📦 Installed Components

### Themes

#### Twenty Twenty-Five (Default)
- **Version**: 1.3
- **Description**: Emphasizes simplicity and adaptability
- **Features**: Full site editing, block patterns, style variations
- **Requirements**: WordPress 6.7+, PHP 7.2+

#### Twenty Twenty-Four
- Full site editing support
- 50+ pattern library
- 7 style variations (Ember, Fossil, Ice, Maelstrom, Mint, Onyx, Rust)

#### Twenty Twenty-Three
- Classic block theme

### Plugins

#### Akismet
- Spam comment protection
- Installed (API key setup required)

## 🚀 Usage

### Initial Startup

```bash
# Clone repository
git clone <repository-url>
cd wordpress-app-template

# Start Docker containers
docker-compose up -d

# Check logs (optional)
docker-compose logs -f
```

### Access URLs

- **WordPress Site**: http://localhost:8000
- **WordPress Admin**: http://localhost:8000/wp-admin
- **phpMyAdmin**: http://localhost:8081

### Container Management

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# View logs
docker-compose logs -f [service-name]

# Check status
docker-compose ps

# Enter container
docker-compose exec wordpress bash
docker-compose exec db mysql -u root -p
```

### VS Code DevContainer

This repository includes a DevContainer configuration for a consistent development environment.

#### Prerequisites

- Visual Studio Code
- Docker Desktop
- Remote - Containers extension for VS Code

#### DevContainer Architecture

```
.devcontainer/
├── devcontainer.json    # VS Code configuration
└── setup.sh             # Post-create setup script

docker/
└── cli/
    └── Dockerfile       # Container image definition

docker-compose.yml
└── cli service          # DevContainer service
```

The DevContainer uses the `cli` service defined in `docker-compose.yml`, which shares the same network as WordPress, MySQL, and phpMyAdmin.

#### Using DevContainer

1. **Open repository in VS Code**
   ```bash
   code /path/to/wordpress-app-template
   ```

2. **Reopen in Container**
   - VS Code will detect `.devcontainer/devcontainer.json`
   - Click "Reopen in Container" prompt
   - Or: Press F1 → "Dev Containers: Reopen in Container"

3. **Wait for container to build**
   - First time: Downloads images and builds container (3-5 minutes)
   - Subsequent times: Starts immediately (10-30 seconds)

4. **Start developing**
   - Terminal opens inside container with PHP 8.4 + WP-CLI
   - Full access to WordPress files
   - IntelliSense and autocomplete enabled

#### DevContainer Features

**Installed Tools**:
- PHP 8.4 CLI with WordPress extensions (mysqli, gd, zip, mbstring, xml, exif)
- WP-CLI (WordPress command-line interface)
- Git
- MySQL client (mariadb-client)

**VS Code Extensions** (Auto-installed):
- PHP Intelephense (IntelliSense and code intelligence)

**Network Access**:
- MySQL database: `db:3306`
- WordPress: http://localhost:8000
- phpMyAdmin: http://localhost:8081

**Working Directory**:
- Container: `/workspace` (repository root)
- WordPress files: `/var/www/html` (mapped to `./wordpress`)
- All changes sync bidirectionally with host machine

#### Common WP-CLI Commands in DevContainer

**Note**: DevContainer runs as root user, so `--allow-root` flag is required for WP-CLI commands.

```bash
# Check WP-CLI info
wp --info --allow-root

# Plugin management
wp plugin list --path=/workspace/wordpress --allow-root
wp plugin activate <plugin-name> --path=/workspace/wordpress --allow-root
wp plugin deactivate <plugin-name> --path=/workspace/wordpress --allow-root

# Theme management
wp theme list --path=/workspace/wordpress --allow-root
wp theme activate <theme-name> --path=/workspace/wordpress --allow-root

# User management
wp user list --path=/workspace/wordpress --allow-root
wp user create newuser user@example.com --role=administrator --path=/workspace/wordpress --allow-root

# Database operations
wp db query "SHOW TABLES" --path=/workspace/wordpress --allow-root
wp db query "SELECT * FROM wp_posts LIMIT 5" --path=/workspace/wordpress --allow-root
wp db check --path=/workspace/wordpress --allow-root

# WordPress core
wp core version --path=/workspace/wordpress --allow-root
wp core update --path=/workspace/wordpress --allow-root
wp core verify-checksums --path=/workspace/wordpress --allow-root

# Interactive shell
wp shell --path=/workspace/wordpress --allow-root
```

#### Development Workflow

**Plugin Development**:
```bash
# Create custom plugin
cd /workspace/wordpress/wp-content/plugins
mkdir my-custom-plugin
cd my-custom-plugin
touch my-custom-plugin.php

# Edit files in VS Code
# Changes sync to host machine automatically

# Activate plugin
wp plugin activate my-custom-plugin --path=/workspace/wordpress --allow-root
```

**Theme Development**:
```bash
# Create custom theme
cd /workspace/wordpress/wp-content/themes
mkdir my-custom-theme
cd my-custom-theme
touch style.css functions.php index.php

# Activate theme
wp theme activate my-custom-theme --path=/workspace/wordpress --allow-root
```

#### Troubleshooting DevContainer

**Container won't start**:
```bash
# Rebuild container
F1 → "Dev Containers: Rebuild Container"

# Or rebuild from terminal
docker-compose build cli
docker-compose up -d cli
```

**Database connection issues**:
```bash
# Check if services are running
docker-compose ps

# Check MySQL is ready (from within DevContainer)
mysql -h db -u wordpress_user -pwordpress_user_password --skip-ssl -e "SELECT 1"

# Restart services
docker-compose restart db wordpress
```

**WP-CLI errors**:
```bash
# Always use --allow-root flag
wp plugin list --allow-root

# Or use --path flag
wp plugin list --path=/workspace/wordpress --allow-root
```

**Permission issues**:
```bash
# Fix WordPress file permissions (from host)
sudo chown -R www-data:www-data wordpress/wp-content
```

**Exit DevContainer**:
- F1 → "Dev Containers: Reopen Folder Locally"
- Or close VS Code
- Services continue running: `docker-compose ps`

## 🗄️ Database Management

### phpMyAdmin Access

1. Access http://localhost:8081
2. Login credentials:
   - **Server**: db
   - **Username**: root or wordpress_user
   - **Password**: root_password or wordpress_user_password
3. Database: wordpress_db

### MySQL CLI Access

```bash
# Connect to MySQL container
docker-compose exec db mysql -u root -p
# Password: root_password

# Or connect as WordPress user
docker-compose exec db mysql -u wordpress_user -p
# Password: wordpress_user_password

# Select database
USE wordpress_db;

# Show tables
SHOW TABLES;
```

### Database Dump and Restore

**Important**: Database dump files (.sql) are NOT tracked in Git for security and repository size reasons.

#### Execution Methods

The database scripts are designed to run **inside the CLI container** and connect directly to MySQL via the Docker network.

**From DevContainer** (recommended):
```bash
# You're already inside the CLI container
bash docker/mysql/scripts/dump.sh
bash docker/mysql/scripts/restore.sh <file>
bash docker/mysql/scripts/reset.sh
```

**From Host Machine**:
```bash
# Execute scripts inside CLI container
docker-compose exec cli bash docker/mysql/scripts/dump.sh
docker-compose exec cli bash docker/mysql/scripts/restore.sh <file>
docker-compose exec cli bash docker/mysql/scripts/reset.sh
```

#### Create Database Dump

```bash
# DevContainer内
bash docker/mysql/scripts/dump.sh

# ホストマシンから
docker-compose exec cli bash docker/mysql/scripts/dump.sh

# Output: docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql.gz
```

#### Restore Database

```bash
# List available dumps
ls -lh docker/mysql/dumps/

# DevContainer内
bash docker/mysql/scripts/restore.sh docker/mysql/dumps/wordpress-20251017_120000.sql.gz

# ホストマシンから
docker-compose exec cli bash docker/mysql/scripts/restore.sh docker/mysql/dumps/wordpress-20251017_120000.sql.gz

# Also supports uncompressed files (.sql)
```

#### Reset Database

```bash
# DevContainer内
bash docker/mysql/scripts/reset.sh

# ホストマシンから
docker-compose exec cli bash docker/mysql/scripts/reset.sh

# After reset, you can:
# - Install WordPress from scratch: http://localhost:8000
# - Restore from a dump file
```

#### Getting Database Dump (New Members)

1. Contact team lead or existing developers
2. Request dump file via secure channel (Slack DM, encrypted storage)
3. Place the .sql or .sql.gz file in `docker/mysql/dumps/` directory
4. Run restore command
5. See `docker/mysql/dumps/README.md` for details

#### Security Guidelines

- Database dumps are excluded from Git (.gitignore)
- Dumps may contain sensitive information (user data, credentials)
- Share dumps only through secure channels
- Delete local dumps after use if they contain production data

## 📝 Development Guide

### Theme Development

Creating custom theme:

```bash
# Navigate to themes directory
cd wordpress/wp-content/themes

# Create new theme directory
mkdir my-custom-theme
cd my-custom-theme

# Create minimum required files
touch style.css index.php functions.php
```

**style.css structure:**
```css
/*
Theme Name: My Custom Theme
Theme URI: https://example.com
Author: Your Name
Author URI: https://example.com
Description: Custom theme description
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: my-custom-theme
*/
```

### Plugin Development

Creating custom plugin:

```bash
# Navigate to plugins directory
cd wordpress/wp-content/plugins

# Create new plugin directory
mkdir my-custom-plugin
cd my-custom-plugin

# Create plugin file
touch my-custom-plugin.php
```

**Plugin file structure:**
```php
<?php
/*
Plugin Name: My Custom Plugin
Plugin URI: https://example.com
Description: Custom plugin description
Version: 1.0
Author: Your Name
Author URI: https://example.com
License: GPL2
Text Domain: my-custom-plugin
*/
```

### Debug Settings

Debug mode is already enabled (`WORDPRESS_DEBUG: 1`).

View debug log:
```bash
# Monitor WordPress debug log
docker-compose exec wordpress tail -f /var/www/html/wp-content/debug.log
```

Additional debug settings in `docker-compose.yml`:
```yaml
environment:
  WORDPRESS_DEBUG: 1
  WORDPRESS_CONFIG_EXTRA: |
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', true);
```

## 🔒 Security

### Production Deployment Notes

This is a **development environment**. For production:

1. **Change authentication keys and salts**
   ```bash
   # Generate new keys
   curl https://api.wordpress.org/secret-key/1.1/salt/
   ```

2. **Change database credentials**
   - Use stronger passwords
   - Change default usernames

3. **Disable debug mode**
   ```yaml
   WORDPRESS_DEBUG: 0
   ```

4. **Set file permissions**
   ```bash
   find wordpress -type d -exec chmod 755 {} \;
   find wordpress -type f -exec chmod 644 {} \;
   ```

5. **Configure SSL/TLS**
   - Enable HTTPS
   - Configure reverse proxy (Nginx, Apache)

## 🎨 Localization

Fully localized in Japanese:

### Included Translation Files

- **Core**: `ja.mo`, `ja.po`, `ja.l10n.php`
- **Admin**: `admin-ja.mo`, `admin-ja.po`
- **Network Admin**: `admin-network-ja.mo`, `admin-network-ja.po`
- **Regions**: `continents-cities-ja.mo`
- **Themes**: Japanese translations for Twenty Twenty-Five, Four, Three
- **JavaScript**: 60+ JSON translation files

### Change Language Settings

In WordPress admin:
1. Login to admin panel
2. **Settings** → **General**
3. Select language in **Site Language**
4. Save changes

## 📚 Git Management

### .gitignore Configuration

Excluded from Git:
```gitignore
.DS_Store                           # macOS system files
docker/mysql/data                   # MySQL data files
wordpress/wp-content/themes/*       # Theme files
wordpress/wp-content/plugins/*      # Plugin files
```

### Version Control Best Practices

**Should be in Git:**
- Custom themes
- Custom plugins
- `docker-compose.yml`
- `.gitignore`
- Project-specific configuration files

**Should NOT be in Git:**
- WordPress core files
- Third-party themes/plugins
- Database files
- Uploaded media files
- Cache files

### Managing Custom Code

To track custom themes/plugins in Git:
```bash
# Add exceptions to .gitignore
echo '!wordpress/wp-content/themes/my-custom-theme/' >> .gitignore
echo '!wordpress/wp-content/plugins/my-custom-plugin/' >> .gitignore
```

## 🐛 Troubleshooting

### Common Issues

#### 1. Port Already in Use

**Error**: `Bind for 0.0.0.0:8000 failed: port is already allocated`

**Solution**:
```bash
# Check port usage
lsof -i :8000
lsof -i :8081

# Kill process or change port in docker-compose.yml
ports:
  - "8080:80"  # Change 8000 → 8080
```

#### 2. Database Connection Error

**Error**: `Error establishing a database connection`

**Solution**:
```bash
# Check if MySQL container is running
docker-compose ps

# Check MySQL logs
docker-compose logs db

# Test database connection
docker-compose exec wordpress wp db check
```

#### 3. Permission Errors

**Solution**:
```bash
# Check/fix ownership
sudo chown -R www-data:www-data wordpress/wp-content

# Or for development
sudo chmod -R 777 wordpress/wp-content
```

#### 4. Container Won't Start

```bash
# Stop and remove volumes, then restart
docker-compose down -v
docker-compose up -d

# Rebuild images
docker-compose build --no-cache
docker-compose up -d
```

#### 5. Database Gets Reset

Database data persists in `./docker/mysql/data`.

```bash
# Check data directory
ls -la docker/mysql/data

# Restore from backup
docker-compose exec -T db mysql -u root -proot_password wordpress_db < backup.sql
```

## 🔄 Maintenance

### WordPress Updates

```bash
# Use WP-CLI in WordPress container
docker-compose exec wordpress wp core update
docker-compose exec wordpress wp core update-db
docker-compose exec wordpress wp plugin update --all
docker-compose exec wordpress wp theme update --all
```

### Docker Image Updates

```yaml
# Update version in docker-compose.yml
wordpress:
  image: wordpress:6.9.0-php8.4
```

```bash
# Pull new images
docker-compose pull
docker-compose up -d
```

### Database Optimization

```bash
# Optimize database
docker-compose exec db mysqlcheck -u root -proot_password --optimize wordpress_db

# Or from WordPress container
docker-compose exec wordpress wp db optimize
```

## 📊 Performance Optimization

### Recommended Settings

#### Increase PHP Memory Limit

Add to `docker-compose.yml`:
```yaml
wordpress:
  environment:
    WORDPRESS_CONFIG_EXTRA: |
      define('WP_MEMORY_LIMIT', '256M');
      define('WP_MAX_MEMORY_LIMIT', '512M');
```

#### Optimize MySQL Settings

Add to `docker-compose.yml`:
```yaml
db:
  command: --max_allowed_packet=64M --innodb_buffer_pool_size=256M
```

#### Cache Plugins

Recommended:
- WP Super Cache
- W3 Total Cache
- Redis Object Cache

## 🧪 Testing Environment

### Using WP-CLI

```bash
# WP-CLI info
docker-compose exec wordpress wp --info

# List plugins
docker-compose exec wordpress wp plugin list

# List themes
docker-compose exec wordpress wp theme list

# Create user
docker-compose exec wordpress wp user create newuser user@example.com --role=administrator

# Search and replace (URL changes)
docker-compose exec wordpress wp search-replace 'http://oldurl.com' 'http://newurl.com'
```

## 📖 Resources

### Official Documentation
- [WordPress Codex (Japanese)](https://wpdocs.osdn.jp/)
- [WordPress Developer Resources](https://developer.wordpress.org/)
- [Docker Hub - WordPress](https://hub.docker.com/_/wordpress)
- [Docker Hub - MySQL](https://hub.docker.com/_/mysql)

### Development Resources
- [WordPress Theme Development Handbook](https://developer.wordpress.org/themes/)
- [WordPress Plugin Development Handbook](https://developer.wordpress.org/plugins/)
- [WP-CLI Command Reference](https://developer.wordpress.org/cli/commands/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)

## 🤝 Contribution

### Development Flow

1. Create feature branch
   ```bash
   git checkout -b feature/my-new-feature
   ```

2. Implement changes

3. Test functionality

4. Commit
   ```bash
   git add .
   git commit -m "Add: new feature description"
   ```

5. Push and create pull request
   ```bash
   git push origin feature/my-new-feature
   ```

### Commit Message Convention

Recommended format:
- `Add:` New feature
- `Fix:` Bug fix
- `Update:` Update existing feature
- `Remove:` Remove feature
- `Docs:` Documentation changes
- `Style:` Code style changes
- `Refactor:` Refactoring

## 📝 License

- WordPress: GPLv2 or later
- This project: Follow project-specific license

## 📞 Support

### If Issues Occur

1. Check troubleshooting section in this document
2. Check Docker logs: `docker-compose logs`
3. Check WordPress debug log
4. Report via GitHub Issues (if applicable)

---

**Last Updated**: 2025-10-17
**WordPress Version**: 6.8.3
**Docker Compose Version**: 3.8
