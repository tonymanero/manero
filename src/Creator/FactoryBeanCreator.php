<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Creator;

class FactoryBeanCreator extends AbstractBeanCreator
{
    private $factory;

    public function __construct(Writeable $writer, string $class, string $factory)
    {
        parent::__construct($writer, $class);
        $this->factory = $factory;
    }

    public function create() : void
    {
        $preAliasTemplate = '
            %indent%/**
            %indent% * @Bean({"aliases" = {';

        $postAliasTemplate = '
            %indent% * }})
            %indent% */
            %indent%public function get%classWithoutBackslashes%() : \\%class%
            %indent%{
            %indent%    return (new \\%factory%())(BeanFactoryRegistry::getInstance()));
            %indent%}';

        $this->getWriter()->write($preAliasTemplate);
        $this->writeAliases();
        $this->getWriter()->write(str_replace(
            [
                '%class%',
                '%factory%',
                '%classWithoutBackslashes%'
            ],
            [
                $this->getClass(),
                $this->factory,
                str_replace('\\', '', $this->getClass()),
            ],
            $postAliasTemplate
        ));

    }
}
