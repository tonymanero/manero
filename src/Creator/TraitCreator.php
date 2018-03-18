<?php
/*
 * Copyright (c) Manero Contributors. All rights reserved.
 * 
 * Licensed under the MIT License. See LICENSE.md file in the
 * project root for full license information.
 */

namespace Manero\Creator;

class TraitCreator implements Writeable
{
    private $handle;

    private $creators;

    public function __construct(string $file)
    {
        $this->handle = fopen($file, 'w');
        $this->creators = [];
    }
    public function create() : void
    {
        $preBeanTemplate = '<?php
        %%
        %%use bitExpert\Disco\BeanFactoryRegistry;
        %%use bitExpert\Disco\Annotations\Alias;
        %%use bitExpert\Disco\Annotations\Bean;
        %%use bitExpert\Disco\Annotations\Parameter;
        %%
        %%trait ManeroConfigTrait
        %%{';

        $postBeanTemplate = '
        %%}
        %%';

        $this->write($preBeanTemplate);
        /** @var \Manero\Creator\Createable $creator */
        foreach ($this->creators as $creator) {
            $creator->create();
        }
        $this->write($postBeanTemplate);
    }

    public function addCreator(Createable $creator) : void
    {
        $this->creators[$creator->getClass()] = $creator;
    }

    public function write(string $string) : void
    {
        $string = preg_replace(
            [
                '/[ \t]+%%/',
                '/[ \t]+%indent%/',
            ],
            [
                '',
                '    ',
            ],
            $string
        );

        fwrite($this->handle, $string);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    public function addAlias(string $alias, string $class) : void
    {
        $this->creators[$class]->addAlias($alias);
    }
}
