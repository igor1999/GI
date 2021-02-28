<?php

namespace GI\SocketDemon\Exchange\Response\Result\SocketDBFailed;

use GI\SocketDemon\Exchange\Response\Result\Base\Error\AbstractError;

class SocketDBFailed extends AbstractError implements SocketDBFailedInterface
{
    const TITLE = 'socket_db_failed';


    /**
     * @extract
     * @return string
     */
    protected function getText()
    {
        return $this->translate('Connection socket id not found in database');
    }
}