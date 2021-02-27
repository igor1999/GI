<?php

namespace GI\SocketDemon\Exchange\Response\Result\SocketExpired;

use GI\SocketDemon\Exchange\Response\Result\Base\Error\AbstractError;

class SocketExpired extends AbstractError implements SocketExpiredInterface
{
    const TITLE = 'socket_expired';


    /**
     * @extract
     * @return string
     */
    protected function getText()
    {
        return $this->translate('Connection expired');
    }
}