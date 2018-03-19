#!/usr/bin/env bash

mkdir -p ./tmp
export VERSION="`git describe --tags HEAD`"
git archive --format=tar `git describe --tags --abbrev=0` | tar x -C tmp
cd tmp
sed -i "" "s/%%dev-master%%/$VERSION/g" ./bin/manero
composer install --no-dev --prefer-dist
curl -o createPhar -L `curl -s https://api.github.com/repos/MacFJA/PharBuilder/releases | grep browser_download_url | head -n 1 | cut -d '"' -f 4`
chmod 755 createPhar
php -d phar.readonly=0 ./createPhar package composer.json
cd ..
mkdir -p build
mv tmp/build/manero.phar build/
rm -rf tmp

