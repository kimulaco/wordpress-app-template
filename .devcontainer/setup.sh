#!/bin/bash

echo "========================================="
echo "WordPress DevContainer Setup"
echo "========================================="
echo ""

# Verify WP-CLI installation
echo "✓ Checking WP-CLI..."
if wp --info --allow-root > /dev/null 2>&1; then
    echo "  WP-CLI is installed"
    wp --version --allow-root
else
    echo "  ⚠️  WP-CLI not found"
fi
echo ""

# Wait for MySQL to be ready
echo "✓ Waiting for MySQL to be ready..."
echo "  (This may take 30-60 seconds on first startup...)"
max_attempts=60
attempt=0

# Try to connect to MySQL using mysql client from within the network
while [ $attempt -lt $max_attempts ]; do
  if mysql -h db -u wordpress_user -pwordpress_user_password --skip-ssl -e "SELECT 1" >/dev/null 2>&1; then
    echo "  ✅ MySQL is ready! (took $((attempt * 2)) seconds)"
    break
  fi
  attempt=$((attempt + 1))
  if [ $((attempt % 5)) -eq 0 ]; then
    echo "  ⏳ Still waiting for MySQL... ($((attempt * 2))s elapsed)"
  fi
  sleep 2
done

if [ $attempt -eq $max_attempts ]; then
  echo "  ❌ MySQL did not start in time"
  echo "  ⚠️  Please check:"
  echo "     - Run 'docker-compose ps' to see service status"
  echo "     - Run 'docker-compose logs db' to see MySQL logs"
  echo "     - MySQL may still be initializing, try waiting a bit longer"
fi
echo ""

# Check WordPress files exist
if [ -f "/workspace/wordpress/wp-config.php" ]; then
  echo "✓ WordPress files found"
else
  echo "  ⚠️  WordPress files not found in /workspace/wordpress/"
fi
echo ""

echo "========================================="
echo "🎉 DevContainer Setup Complete!"
echo "========================================="
echo ""
echo "🌐 URLs:"
echo "  WordPress:   http://localhost:8000"
echo "  phpMyAdmin:  http://localhost:8081"
echo ""
echo "📦 Available Tools:"
echo "  - PHP 8.4 CLI"
echo "  - WP-CLI"
echo "  - Git"
echo "  - Docker & Docker Compose"
echo ""
echo "💡 Useful WP-CLI commands:"
echo "  wp plugin list --path=/workspace/wordpress --allow-root"
echo "  wp theme list --path=/workspace/wordpress --allow-root"
echo "  wp user list --path=/workspace/wordpress --allow-root"
echo "  wp db query \"SELECT * FROM wp_posts LIMIT 5\" --path=/workspace/wordpress --allow-root"
echo ""
echo "💡 Docker commands:"
echo "  docker-compose ps"
echo "  docker-compose logs wordpress"
echo "  docker-compose restart wordpress"
echo ""
echo "📂 Development directories:"
echo "  Plugins:  /workspace/wordpress/wp-content/plugins/"
echo "  Themes:   /workspace/wordpress/wp-content/themes/"
echo "========================================="
