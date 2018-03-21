<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 *
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace ManeroTest\Creator;

use Manero\Creator\InvocableBeanCreator;
use Manero\Creator\Writeable;
use PHPUnit\Framework\TestCase;
use Mockery as M;

class AbstractBeanCreatorTest extends TestCase
{
    public function testConstruction()
    {
        $writeable = M::mock(Writeable::class);

        $creator = new TestAbstractBeanCreator($writeable, 'foo');

        self::assertAttributeSame($writeable, 'writer', $creator);
        self::assertAttributeSame('foo', 'class', $creator);
        self::assertAttributeSame(['foo'], 'aliases', $creator);
    }

    public function testAddingAliasOnce()
    {
        $writeable = M::mock(Writeable::class);

        $creator = new TestAbstractBeanCreator($writeable, 'foo');

        $creator->addAlias('bar');
        self::assertAttributeSame(['foo', 'bar'], 'aliases', $creator);
    }

    public function testAddingAliasTwice()
    {
        $writeable = M::mock(Writeable::class);

        $creator = new TestAbstractBeanCreator($writeable, 'foo');

        $creator->addAlias('foo');
        self::assertAttributeSame(['foo'], 'aliases', $creator);
    }

    public function testGettingClassNameREturnsInjectedClassname()
    {
        $writeable = M::mock(Writeable::class);

        $creator = new TestAbstractBeanCreator($writeable, 'foo');

        self::assertAttributeSame('foo', 'class', $creator);
        self::assertSame('foo', $creator->getClass());
    }

    public function testGEttingWriterREturnsInjectedInstance()
    {
        $writeable = M::mock(Writeable::class);

        $creator = new TestAbstractBeanCreator($writeable, 'foo');
        self::assertAttributeSame($writeable, 'writer', $creator);

        self::assertSame($writeable, $creator->getWriter());
    }

    public function testThatWritingAliasesReturnsCorrectStringWithOneAlias()
    {
        $writeable = M::mock(Writeable::class);
        $writeable->shouldReceive('write')->with(
            '
        %indent% *     @Alias({"name" = "foo"})'
        );

        $creator = new TestAbstractBeanCreator($writeable, 'foo');

        self::assertTrue($creator->wrapWriteAliases());
    }

    public function testThatWritingAliasesReturnsCorrectStringWithMultipleAliases()
    {
        $writeable = M::mock(Writeable::class);
        $writeable->shouldReceive('write')->with(
            '
        %indent% *     @Alias({"name" = "foo"}),
        %indent% *     @Alias({"name" = "bar"})'
        );

        $creator = new TestAbstractBeanCreator($writeable, 'foo');
        $creator->addAlias('bar');

        self::assertTrue($creator->wrapWriteAliases());
    }
}
