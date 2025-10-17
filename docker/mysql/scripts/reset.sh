#!/bin/bash
set -e

echo "Resetting database to empty state..."

# Drop and recreate database
mysql -h db -u root -proot_password --skip-ssl -e "
DROP DATABASE IF EXISTS wordpress_db;
CREATE DATABASE wordpress_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
"

echo "Database has been reset successfully!"
echo ""
echo "The database is now empty. You can:"
echo "  - Install WordPress: http://localhost:8000"
echo "  - Restore from dump: bash docker/mysql/scripts/restore.sh <dump-file>"
