<?php

namespace GI\REST\Route\Simple\Method;

use GI\REST\Route\Simple\AbstractSimple;

use GI\REST\Request\Server\ServerInterface;

abstract class AbstractMethod extends AbstractSimple implements MethodInterface
{
    const METHOD = '';


    /**
     * @param string $source
     * @return bool
     * @throws \Exception
     */
    public function validateByString(string $source)
    {
        $this->setSource($source);

        return $this->setValid($source == static::METHOD)->isValid();
    }

    /**
     * @param ServerInterface $server
     * @return bool
     * @throws \Exception
     */
    public function validateByServer(ServerInterface $server)
    {
        return $this->validateByString($server->getRequestMethod());
    }
}