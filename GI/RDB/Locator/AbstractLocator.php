<?php

namespace GI\RDB\Locator;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractLocator implements LocatorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @throws \Exception
     */
    public function getORMFactory()
    {
        $this->giThrowNotSetException('ORM-Factory');
    }
}