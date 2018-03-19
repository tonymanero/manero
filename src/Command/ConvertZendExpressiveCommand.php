<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Command;

use Manero\Service\ConvertZendExpressiveService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertZendExpressiveCommand extends Command
{
    protected function configure()
    {
        $this->setName('convert:zend-expressive')
            ->setDescription('Convert Zend Expressive configuration to disco')
            ->setHelp('
This task will convert a ZendExpressive 3 configuration to a Trait 
usable by Disco.

To create the necessary JSON-File add the following line to the file 
"config/container.php" within your Expresive-project:

    file_put_contents(getcwd() . \'/config.json\', json_encode($config));

Add that right before the "return"-line.

It will provide you with a JSON-encoded DI-configuration that can then
be read by `manero` like this:

    php manero.phar <path/to/config.json>
            ')
            ->addArgument('configurationFile', InputArgument::REQUIRED, 'The Configuration-File to convert')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile    = $input->getArgument('configurationFile');
        $configuration = json_decode(file_get_contents($configFile), true);

        $outputFile = 'ManeroConfigTrait.php';

        $service = new ConvertZendExpressiveService(
            $configuration['dependencies'],
            new \SplFileInfo(getcwd() . '/' . $outputFile)
        );

        $service();

        $output->writeln('done');
    }
}
