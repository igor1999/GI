<?php

namespace GI\SocketDemon\Exchange\Response\Result\AuthReject;

use GI\SocketDemon\Exchange\Response\Result\Base\Error\AbstractError;

class AuthReject extends AbstractError implements AuthRejectInterface
{
    const TITLE = 'auth_reject';


    /**
     * @extract
     * @return string
     */
    protected function getText()
    {
        return $this->translate('Your authentication failed');
    }
}