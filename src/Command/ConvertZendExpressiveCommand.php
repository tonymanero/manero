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
            ->addArgument('configurationFile', InputArgument::REQUIRED, 'The Configuration-File to convert')
            ->addArgument('outputFile', InputArgument::REQUIRED, 'The path where the configuration shall be created at')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile    = $input->getArgument('configurationFile');
        $configuration = json_decode(file_get_contents($configFile), true);

        $outputFile = $input->getArgument('outputFile');

        $service = new ConvertZendExpressiveService(
            $configuration['dependencies'],
            new \SplFileInfo(getcwd() . '/' . $outputFile)
        );

        $service();

        $output->writeln('done');
    }
}
