#!/usr/bin/env bash

mkdir -p ./build
export VERSION="`git describe --tags HEAD`"
rm -rf ./build/*
git archive --format=tar `git describe --tags --abbrev=0` | tar x -C build
cd build
sed -i "" "s/%%dev-master%%/$VERSION/g" ./bin/manero
composer install --no-dev --prefer-dist
curl -o createPhar -L `curl -s https://api.github.com/repos/MacFJA/PharBuilder/releases | grep browser_download_url | head -n 1 | cut -d '"' -f 4`
chmod 755 createPhar
php -d phar.readonly=0 ./createPhar package composer.json
cd ..
