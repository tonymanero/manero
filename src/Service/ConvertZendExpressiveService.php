<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Service;

use Manero\Creator\FactoryBeanCreator;
use Manero\Creator\InvocableBeanCreator;
use Manero\Creator\TraitCreator;
use SplFileInfo;

class ConvertZendExpressiveService
{
    private $dependencies;

    public function __construct(array $dependencies, SplFileInfo $traitFile)
    {
        $this->dependencies = array_merge(
            [
                'factories' => [],
                'invocables' => [],
                'aliases' => [],
            ],
            $dependencies
        );

        $this->trait = new TraitCreator($traitFile->getPathname());
    }

    public function __invoke()
    {
        foreach ($this->dependencies['factories'] as $class => $factory) {
            $this->trait->addCreator(new FactoryBeanCreator($this->trait, $class, $factory));
        }

        foreach ($this->dependencies['invocables'] as $class) {
            $this->trait->addCreator(new InvocableBeanCreator($this->trait, $class));
        }

        foreach ($this->dependencies['aliases'] as $alias => $class) {
            $this->trait->addAlias($alias, $class);
        }

        $this->trait->create();
    }
}
