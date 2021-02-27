<?php

namespace GI\REST\Route\Simple\Protocol;

use GI\REST\Route\Simple\AbstractSimple;

use GI\REST\Request\Server\ServerInterface;

abstract class AbstractProtocol extends AbstractSimple implements ProtocolInterface
{
    const PROTOCOL = '';


    /**
     * @param string $source
     * @return bool
     * @throws \Exception
     */
    public function validateByString(string $source)
    {
        $this->setSource($source);

        return $this->setValid($source == static::PROTOCOL)->isValid();
    }

    /**
     * @param ServerInterface $server
     * @return bool
     * @throws \Exception
     */
    public function validateByServer(ServerInterface $server)
    {
        return $this->validateByString($server->getRequestScheme());
    }
}