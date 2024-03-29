#!/bin/bash

# Drop Dulu
vendor/doctrine/orm/bin/doctrine orm:schema-tool:drop --force

# Create
vendor/doctrine/orm/bin/doctrine orm:schema-tool:create

# Recreate data
rm -fRv data/foto/
rm -fRv data/receipt/
mkdir -p data/foto/
mkdir -p data/receipt/

# Seeding data
php seeder.php

# Pindah Ke Direktori Test
cd application/tests/

# Call PHPUNIT
../../vendor/phpunit/phpunit/phpunit --coverage-text --verbose

# Back to ppdb
cd ../..
# php vendor/bin/coveralls -v
