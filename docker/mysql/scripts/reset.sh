#!/bin/bash
set -e

echo "Resetting database to empty state..."

# Drop and recreate database
docker-compose exec -T db mysql -u root -proot_password -e "
DROP DATABASE IF EXISTS wordpress_db;
CREATE DATABASE wordpress_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
"

echo "Database has been reset successfully!"
echo ""
echo "The database is now empty. You can:"
echo "  - Install WordPress: http://localhost:8000"
echo "  - Restore from dump: bash database/scripts/restore.sh <dump-file>"
