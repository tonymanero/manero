<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 *
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Command;

use Manero\Creator\TraitCreator;
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

Call it right within your Expressive-Apps home-folder like this:

    php /path/to/manero.phar convert:zend-expressive config/config.php
            ')
            ->addArgument('configurationFile', InputArgument::REQUIRED, 'The Configuration-File to convert')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getArgument('configurationFile');

        try {
            $configuration = require $configFile;
        } catch (\Throwable $exception) {
            $output->writeln($exception->getMessage());
            return;
        }

        $outputFile = 'ManeroConfigTrait.php';

        $service = new ConvertZendExpressiveService(
            $configuration['dependencies'],
            new TraitCreator(getcwd() . '/' . $outputFile)
        );

        $service();

        $output->writeln('Created file "ManeroConfigTrait.php');
        $output->writeln('Copy that file to your Disco-Project, adapt the namespace and include it via "use"');
    }
}
