#!/bin/bash
set -e

DUMP_FILE="${1}"

if [ -z "${DUMP_FILE}" ]; then
  echo "Error: Please specify dump file"
  echo ""
  echo "Usage: bash docker/db/scripts/restore.sh <dump-file>"
  echo "Example: bash docker/db/scripts/restore.sh docker/db/dumps/wordpress-20251017_120000.sql.gz"
  echo ""
  echo "Available dumps:"
  ls -lh docker/db/dumps/*.sql* 2>/dev/null || echo "  (no dumps found)"
  exit 1
fi

if [ ! -f "${DUMP_FILE}" ]; then
  echo "Error: Dump file not found: ${DUMP_FILE}"
  exit 1
fi

echo "Restoring database from: ${DUMP_FILE}"

# Check if file is gzipped
if [[ "${DUMP_FILE}" == *.gz ]]; then
  echo "Decompressing and restoring..."
  gunzip -c "${DUMP_FILE}" | mysql \
    -h db \
    -u root \
    -proot_password \
    --skip-ssl \
    wordpress_db
else
  mysql \
    -h db \
    -u root \
    -proot_password \
    --skip-ssl \
    wordpress_db < "${DUMP_FILE}"
fi

echo "Database restored successfully!"
echo ""
echo "Access WordPress at: http://localhost:8000"

