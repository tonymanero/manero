<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 *
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Creator;

interface Writeable
{
    public function write(string $string) : void;
}
