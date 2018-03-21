<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace ManeroTest\Creator;

use Manero\Creator\AbstractBeanCreator;
use Manero\Creator\FactoryBeanCreator;
use Manero\Creator\InvocableBeanCreator;
use Manero\Creator\Writeable;
use PHPUnit\Framework\TestCase;
use Mockery as M;

class FactoryBeanCreatorTest extends TestCase
{

    public function testCreate()
    {
        $writer = M::mock(Writeable::class);
        $writer->shouldReceive('write')->with('
            %indent%/**
            %indent% * @Bean({"aliases" = {');
        $writer->shouldReceive('write')->with('
        %indent% *     @Alias({"name" = "\\Foo\\Bar"})');
        $writer->shouldReceive('write')->with('
            %indent% * }})
            %indent% */
            %indent%public function getFooBar() : \\\\Foo\\Bar
            %indent%{
            %indent%    return (new \\baz())(BeanFactoryRegistry::getInstance());
            %indent%}');

        $creator = new FactoryBeanCreator($writer, '\\Foo\\Bar', 'baz');
        $creator->create();

        self::assertInstanceof(AbstractBeanCreator::class, $creator);
    }
}
