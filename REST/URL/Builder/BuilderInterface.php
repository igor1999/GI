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

use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\Util\TextProcessing\Escaper\URL\EscaperInterface as URLEscaperInterface;
use GI\REST\URL\Query\QueryInterface;

/**
 * Interface BuilderInterface
 * @package GI\REST\URL\Builder
 *
 * @method BuilderInterface setSchemaToHttp()
 * @method BuilderInterface setSchemaToHttps()
 * @method BuilderInterface setSchemaToFtp()
 * @method BuilderInterface setSchemaToEmail()
 */
interface BuilderInterface extends StringConvertableInterface
{
    /**
     * @return string
     */
    public function getSchema();

    /**
     * @param string $schema
     * @return static
     */
    public function setSchema(string $schema);

    /**
     * @return static
     */
    public function setDefaultSchema();

    /**
     * @return string
     */
    public function getUser();

    /**
     * @param string $user
     * @return static
     */
    public function setUser(string $user);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     * @return static
     */
    public function setPassword(string $password);

    /**
     * @return string
     */
    public function getHost();

    /**
     * @param string $host
     * @return static
     */
    public function setHost(string $host);

    /**
     * @return int
     */
    public function getPort();

    /**
     * @param int $port
     * @return static
     */
    public function setPort(int $port);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path
     * @return static
     */
    public function setPath(string $path);

    /**
     * @return QueryInterface
     */
    public function getQuery();

    /**
     * @return string
     */
    public function getFragment();

    /**
     * @param string $fragment
     * @return static
     */
    public function setFragment(string $fragment);

    /**
     * @return URLEscaperInterface
     */
    public function getEscaper();

    /**
     * @return static
     * @throws \Exception
     */
    public function reset();

    /**
     * @return string
     * @throws \Exception
     */
    public function toString();
}