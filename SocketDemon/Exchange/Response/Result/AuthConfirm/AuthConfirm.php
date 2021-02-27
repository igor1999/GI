<?php

namespace GI\SocketDemon\Exchange\Response\Result\AuthConfirm;

use GI\SocketDemon\Exchange\Response\Result\Base\AbstractResult;

use GI\SocketDemon\Exchange\Response\I18n\GlossaryAwareTrait;

class AuthConfirm extends AbstractResult implements AuthConfirmInterface
{
    use GlossaryAwareTrait;


    const TITLE = 'auth_confirm';


    /**
     * Confirm constructor.
     */
    public function __construct()
    {
        $this->setConfirmed(true);
    }

    /**
     * @extract
     * @return string
     */
    protected function getText()
    {
        return $this->translate('Authentication successful');
    }
}