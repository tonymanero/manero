#!/usr/bin/env bash

mkdir -p ./tmp
export VERSION="`git describe --tags | cut -d "-" -f 1`"
TAG=`git describe --tags --abbrev=0`
git archive --format=tar $TAG | tar x -C tmp
cd tmp
sed -i "" "s/%%dev-master%%/$VERSION/g" ./bin/manero
composer install --no-dev --prefer-dist
../vendor/bin/php-scoper add-prefix --output-dir=../tmp2 --working-dir=. --config=../scoper.inc.php
cd ../tmp2
composer dumpautoload --classmap-authoritative
curl -o createPhar -L `curl -s https://api.github.com/repos/MacFJA/PharBuilder/releases | grep browser_download_url | head -n 1 | cut -d '"' -f 4`
chmod 755 createPhar
php -d phar.readonly=0 ./createPhar package composer.json
cd ..
mkdir -p build
mv tmp2/build/manero.phar build/
rm -rf tmp
rm -rf tmp2

