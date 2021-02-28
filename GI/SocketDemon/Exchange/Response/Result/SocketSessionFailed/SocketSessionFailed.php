<?php

namespace GI\SocketDemon\Exchange\Response\Result\SocketSessionFailed;

use GI\SocketDemon\Exchange\Response\Result\Base\Error\AbstractError;

class SocketSessionFailed extends AbstractError implements SocketSessionFailedInterface
{
    const TITLE = 'socket_session_failed';


    /**
     * @extract
     * @return string
     */
    protected function getText()
    {
        return $this->translate('Actual session does not exists');
    }
}