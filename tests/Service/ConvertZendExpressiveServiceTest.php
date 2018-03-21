<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 *
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace ManeroTest\Service;

use Hamcrest\Matchers;
use Manero\Creator\FactoryBeanCreator;
use Manero\Creator\InvocableBeanCreator;
use Manero\Creator\TraitCreator;
use Manero\Service\ConvertZendExpressiveService;
use PHPUnit\Framework\TestCase;
use Mockery as M;
use SplFileInfo;

class ConvertZendExpressiveServiceTest extends TestCase
{

    public function testConstructor()
    {
        $trait = M::mock(TraitCreator::class);

        $service = new ConvertZendExpressiveService([], $trait);

        self::assertInstanceOf(ConvertZendExpressiveService::class, $service);
        self::assertAttributeSame($trait, 'trait', $service);
        self::assertAttributeSame(
            [
                'factories' => [],
                'invocables' => [],
                'aliases' => [],
            ],
            'dependencies',
            $service
        );
    }

    public function testinvokeWithFactory()
    {
        $trait = M::mock(TraitCreator::class);
        $trait->shouldReceive('addCreator')->once()->with(Matchers::equalTo(
            new FactoryBeanCreator($trait, 'classA', 'classB')
        ));
        $trait->shouldREceive('create')->once();

        $config = ['factories' => ['classA' => 'classB']];

        $service = new ConvertZendExpressiveService($config, $trait);
        self::assertInstanceOf(
            ConvertZendExpressiveService::class,
            $service
        );

        $service();
    }

    public function testinvokeWithInvocable()
    {
        $trait = M::mock(TraitCreator::class);
        $trait->shouldReceive('addCreator')->with(Matchers::equalTo(
            new InvocableBeanCreator($trait, 'classA')
        ));
        $trait->shouldREceive('create')->once();

        $config = ['invocables' => ['classA']];

        $service = new ConvertZendExpressiveService($config, $trait);
        self::assertInstanceOf(
            ConvertZendExpressiveService::class,
            $service
        );

        $service();
    }

    public function testinvokeWithAlias()
    {
        $trait = M::mock(TraitCreator::class);
        $trait->shouldReceive('addAlias')->with('classA', 'classB');
        $trait->shouldReceive('create')->once();

        $config = ['aliases' => ['classA' => 'classB']];

        $service = new ConvertZendExpressiveService($config, $trait);
        self::assertInstanceOf(
            ConvertZendExpressiveService::class,
            $service
        );

        $service();
    }
}
