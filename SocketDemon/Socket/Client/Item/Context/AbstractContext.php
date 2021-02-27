<?php

namespace GI\SocketDemon\Socket\Client\Item\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractContext implements ContextInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @throws \Exception
     */
    public function getBufferLength()
    {
        $this->giThrowNotSetException('Buffer length');
    }
}