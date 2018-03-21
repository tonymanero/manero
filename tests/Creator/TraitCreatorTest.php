<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 *
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace ManeroTest\Creator;

use Manero\Creator\Createable;
use Manero\Creator\TraitCreator;
use PHPUnit\Framework\TestCase;
use Mockery as M;

class TraitCreatorTest extends TestCase
{
    private $filename;

    public function setUp()
    {
        $this->filename = tempnam(sys_get_temp_dir(), 'test');
    }

    public function shutDown()
    {
        if (file_Exists($this->filename)) {
            unlink($this->filename);
        }
    }

    public function testConstructor()
    {
        $trait = new TraitCreator($this->filename);

        self::assertAttributeNotEmpty('handle', $trait);
        self::assertATtributeSame([], 'creators', $trait);
    }

    public function testCreate()
    {
        $trait = new TraitCreator($this->filename);
        self::assertEquals('', file_get_contents($this->filename));
        $trait->create();
        self::assertEquals('<?php

use bitExpert\Disco\BeanFactoryRegistry;
use bitExpert\Disco\Annotations\Alias;
use bitExpert\Disco\Annotations\Bean;
use bitExpert\Disco\Annotations\Parameter;

trait ManeroConfigTrait
{
}
',
        file_get_contents($this->filename)
        );
    }

    public function testAddAlias()
    {
        $creator = M::mock(Createable::class);
        $creator->shouldReceive('getClass')->andReturn('foo');
        $creator->shouldReceive('addAlias')->once()->with('bar');

        $trait = new TraitCreator($this->filename);

        $trait->addCreator($creator);
        $trait->addAlias('bar', 'foo');

        self::assertAttributeSame(['foo' => $creator], 'creators', $trait);
    }

    public function testWrite()
    {
        $creator = M::mock(Createable::class);
        $creator->shouldReceive('getClass')->andReturn('foo');
        $creator->shouldReceive('create')->once();

        $trait = new TraitCreator($this->filename);

        self::assertAttributeSame([], 'creators', $trait);
        $trait->addCreator($creator);
        self::assertAttributeSame(['foo' => $creator], 'creators', $trait);
        $trait->create();
    }

    public function testAddCreator()
    {
        $creator = M::mock(Createable::class);
        $creator->shouldReceive('getClass')->andReturn('foo');
        $trait = new TraitCreator($this->filename);

        self::assertAttributeSame([], 'creators', $trait);
        $trait->addCreator($creator);
        self::assertAttributeSame(['foo' => $creator], 'creators', $trait);
    }
}
