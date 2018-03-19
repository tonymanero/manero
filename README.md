# Manero

Create a configuration for [Disco](https://github.com/bitExpert/disco) from a
JSON-Encoded version of your current DI-Configuration.

## Usage

Download the latest PHAR-file from https://github.com/tonymanero/manero/releases and invoke it.

```bash
php manero.phar convert:<container-implementation> config.json
```

This will create a trait `ManeroConfigTrait.php` from the container-implementations configuration `config.json`.

Therer will be some manual labour needed to finalize the configuration due to
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
