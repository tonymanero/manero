# Manero

Create a configuration for [Disco](https://github.com/bitExpert/disco) from a
JSON-Encoded version of your current DI-Configuration.

[![Build Status](https://travis-ci.org/tonymanero/manero.svg?branch=master)](https://travis-ci.org/tonymanero/manero)
[![Coverage Status](https://coveralls.io/repos/github/tonymanero/manero/badge.svg?branch=master)](https://coveralls.io/github/tonymanero/manero?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tonymanero/manero/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tonymanero/manero/?branch=master)

![Github Releases](https://img.shields.io/github/downloads/tonymanero/manero/latest/total.svg)
![PHP-Version](	https://img.shields.io/packagist/php-v/tonymanero/manero.svg)
![License](https://img.shields.io/packagist/l/tonymanero/manero.svg)

## Usage

Download the latest PHAR-file from https://github.com/tonymanero/manero/releases
and invoke it within your applications working directory.

```bash
php manero.phar convert:<container-implementation> path/to/config.php
```

This will create a trait `ManeroConfigTrait.php` from the container-implementations configuration.

There will be some manual labour needed to finalize the configuration due to
quirks in the way f.e. ZendExpressive configures it's DI.

You will also need to provide the propper namespace for the trait.

To get a list of currently available container-implementations invoke `php manero.phar`.

## Name

Tony Manero is the main character from the film [Saturday Night Fever](https://en.wikipedia.org/wiki/Saturday_Night_Fever)

## Contributions

Contributions are welcome! If you find that a conversion from your favourite DI-Container-implementation is missing, feel free to create a PullRequest.

## License

Copyright (c) [Manero Contributors](https://github.com/tonymanero/manero/graphs/contributors). All rights reserved.

Licensed under the MIT License. See LICENSE.md file in the project root for full license information.
