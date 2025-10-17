#!/bin/bash
set -e

TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DUMP_FILE="docker/mysql/dumps/wordpress-${TIMESTAMP}.sql"

echo "Creating database dump..."
mysqldump \
  -h db \
  -u root \
  -proot_password \
  --skip-ssl \
  --single-transaction \
  --no-tablespaces \
  --skip-comments \
  --add-drop-table \
  wordpress_db > "${DUMP_FILE}"

# Compress to save space
echo "Compressing dump file..."
gzip "${DUMP_FILE}"
DUMP_FILE="${DUMP_FILE}.gz"

echo "Database dumped successfully!"
echo "File: ${DUMP_FILE}"
echo "Size: $(du -h ${DUMP_FILE} | cut -f1)"

