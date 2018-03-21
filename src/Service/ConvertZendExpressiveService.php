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

class ConvertZendExpressiveService
{
    private $dependencies;

    public function __construct(array $dependencies, TraitCreator $trait)
    {
        $this->dependencies = array_merge(
            [
                'factories' => [],
                'invocables' => [],
                'aliases' => [],
            ],
            $dependencies
        );

        $this->trait = $trait;
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
