<?php

namespace GI\SocketDemon\Exchange\Response\Result\SocketAlreadyExists;

use GI\SocketDemon\Exchange\Response\Result\Base\Error\AbstractError;

class SocketAlreadyExists extends AbstractError implements SocketAlreadyExistsInterface
{
    const TITLE = 'socket_already_exists';


    /**
     * @extract
     * @return string
     */
    protected function getText()
    {
        return $this->translate('Connection with given socket id already exists');
    }
}