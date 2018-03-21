<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 *
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace ManeroTest\Creator;

use Manero\Creator\AbstractBeanCreator;

class TestAbstractBeanCreator extends AbstractBeanCreator
{

    public function create(): void
    {
        // Do nothing on purpose.
    }

    public function wrapWriteAliases()
    {
        $this->writeAliases();

        return true;
    }
}
