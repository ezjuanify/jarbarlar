#!/bin/bash

set -e

echo "==> Starting MySQL container initialization..."
docker-entrypoint.sh mysqld &

until mysqladmin ping -h"localhost" --silent; do
    sleep 1
done

if mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" -e "SELECT 1 FROM wp_options LIMIT 1;" >/dev/null 2>&1; then
  echo "==> Existing data detected. Skipping import."
  wait -n
  exit 0
fi

if [ -n "$MOCK_FILE_ID" ]; then
    SQL_FILE="/tmp/jarbarlar.sql"

    echo "==> Downloading SQL data from Google Drive (File ID: $MOCK_FILE_ID)"
    # Step 1: request confirmation token
    CONFIRM=$(curl -sc /tmp/cookie "https://drive.google.com/uc?export=download&id=${MOCK_FILE_ID}" | grep -o 'confirm=[^&]*' | sed 's/confirm=//')
    
    # Step 2: download actual file
    curl -Lb "/tmp/cookie" "https://drive.google.com/uc?export=download&confirm=${CONFIRM}&id=${MOCK_FILE_ID}" -o "$SQL_FILE"

    # Validate file contents
    if grep -q "<!DOCTYPE html>" "$SQL_FILE"; then
        echo "!! ERROR: Gogole Drive returned a HTML page instead of SQL."
        exit 1
    fi

    echo "==> Importing $SQL_FILE into database: $MYSQL_DATABASE"
    mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < "$SQL_FILE"
    echo "==> SQL import complete."
fi

wait -n