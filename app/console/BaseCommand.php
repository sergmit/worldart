<?php

namespace Console;

abstract class BaseCommand
{
    /**
     * @param array|null $args
     * @return void
     */
    abstract public function execute(array $args = null);
}