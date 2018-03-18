<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Creator;

abstract class AbstractBeanCreator implements Createable
{
    private $class;

    private $aliases;

    private $writer;

    public function __construct(Writeable $writer, string $class)
    {
        $this->writer = $writer;
        $this->class = $class;
        $this->aliases = [];
        $this->addAlias($class);
    }

    public function getClass() : string
    {
        return $this->class;
    }

    public function addAlias(string $alias) : void
    {
        if (in_array($alias, $this->aliases)) {
            return;
        }

        $this->aliases[] = $alias;
    }

    protected function writeAliases() : void
    {
        $template = '
        %indent% *     @Alias({"name" = "%alias%"})';
        foreach ($this->aliases as $alias) {
            $this->getWriter()->write(str_Replace('%alias%', $alias, $template));
        }
    }

    public function getWriter() : Writeable
    {
        return $this->writer;
    }
}
