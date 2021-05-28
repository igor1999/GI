<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\REST\URL\Builder;

use GI\REST\Constants\Protocol;
use GI\REST\URL\Query\Query;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\Escaper\URL\EscaperInterface as URLEscaperInterface;
use GI\REST\URL\Query\QueryInterface;

/**
 * Class Builder
 * @package GI\REST\URL\Builder
 *
 * @method BuilderInterface setSchemaToHttp()
 * @method BuilderInterface setSchemaToHttps()
 * @method BuilderInterface setSchemaToFtp()
 * @method BuilderInterface setSchemaToEmail()
 */
class Builder implements BuilderInterface
{
    use ServiceLocatorAwareTrait;


    const PROTOCOL_AND_HOST_SEPARATOR = Protocol::PROTOCOL_AND_HOST_SEPARATOR;

    const SCHEMA_SETTER_PREFIX        = 'setSchemaTo';


    /**
     * @var string
     */
    private $schema = '';

    /**
     * @var string
     */
    private $user = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $host = '';

    /**
     * @var int
     */
    private $port = 0;

    /**
     * @var string
     */
    private $path = '';

    /**
     * @var QueryInterface
     */
    private $query;

    /**
     * @var string
     */
    private $fragment = '';

    /**
     * @var URLEscaperInterface
     */
    private $escaper;


    /**
     * Builder constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->query = $this->getGiServiceLocator()->getDependency(QueryInterface::class,Query::class);

        $this->escaper = $this->getGiServiceLocator()->getUtilites()->getEscaperFactory()->createURL();
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @hydrate
     * @param string $schema
     * @return static
     */
    public function setSchema(string $schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return static
     */
    public function setDefaultSchema()
    {
        $this->setSchemaToHttp();

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $schema = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseAfterPrefix($method, static::SCHEMA_SETTER_PREFIX);
        } catch (\Exception $exception) {
            $schema = null;
            $this->getGiServiceLocator()->throwMagicMethodException($method);
        }

        $this->setSchema($schema);

        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return static
     */
    public function setUser(string $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return static
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return static
     */
    public function setHost(string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return static
     */
    public function setPort(int $port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return static
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return QueryInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param string $fragment
     * @return static
     */
    public function setFragment(string $fragment)
    {
        $this->fragment = $fragment;

        return $this;
    }

    /**
     * @return URLEscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function reset()
    {
        $this->setSchema('')
            ->setUser('')
            ->setPassword('')
            ->setHost('')
            ->setPort('')
            ->setPath('')
            ->setFragment(null);

        $this->getQuery()->clean();

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $result = '';

        if (!empty($this->schema)) {
            $result .= $this->schema . static::PROTOCOL_AND_HOST_SEPARATOR;
        }

        if (!empty($this->user)) {
            $result .= $this->user;

            if (!empty($this->password)) {
                $result .= ':' . $this->password;
            }

            $result .= '@';
        }

        if (!empty($this->host)) {
            $result .= $this->host;

            if (!empty($this->port)) {
                $result .= ':' . $this->port;
            }
        }

        if (!empty($this->path)) {
            $result .= $this->path;
        }

        if (!$this->getQuery()->isEmpty()) {
            $result .= '?' . $this->getQuery()->toString();
        }

        if (!empty($this->fragment)) {
            $result .= '#' . $this->getEscaper()->escape($this->fragment);
        }

        return $result;
    }
}