<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Creator;

class InvocableBeanCreator extends AbstractBeanCreator
{
    public function create() : void
    {
        $preAliasTemplate = '
            %indent%/**
            %indent% * @Bean({"aliases" = {';

        $postAliasTemplate = '
            %indent% * }})
            %indent% */
            %indent%public function get%classWithoutBackslashes%() : \%class%
            %indent%{
            %indent%    return new \%class%();
            %indent%}';

        $this->getWriter()->write($preAliasTemplate);
        $this->writeAliases();
        $this->getWriter()->write(str_replace(
            [
                '%class%',
                '%classWithoutBackslashes%',
            ], [
                $this->getClass(),
                str_replace('\\', '', $this->getClass()),
            ],
            $postAliasTemplate
        ));

    }
}
