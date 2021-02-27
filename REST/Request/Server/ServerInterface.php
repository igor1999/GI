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
namespace GI\REST\Request\Server;

use GI\Storage\Collection\MixedCollection\HashSet\Closable\ClosableInterface as ClosableHashSetInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\CLI\CommandLine\CommandLineInterface;

/**
 * Interface ServerInterface
 * @package GI\REST\Request\Server
 *
 * @method string getServerProtocol()
 * @method ServerInterface setServerProtocol(string $protocol)
 *
 * @method string getRequestScheme()
 * @method ServerInterface setRequestScheme(string $scheme)
 *
 * @method string getHttpHost()
 * @method ServerInterface setHttpHost(string $host)
 *
 * @method ServerInterface setRequestPort(int $port)
 *
 * @method string getRequestMethod()
 * @method ServerInterface setRequestMethod(string $method)
 */
interface ServerInterface extends ClosableHashSetInterface
{
    /**
     * @return CommandLineInterface
     */
    public function getCommandLine();

    /**
     * @return bool
     */
    public function isOSWindows();

    /**
     * @return string
     * @throws \Exception
     */
    public function getRequestPort();

    /**
     * @return string
     * @throws \Exception
     */
    public function getUri();

    /**
     * @return string
     * @throws \Exception
     */
    public function getUriPath();

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToGet();

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToPost();

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToPut();

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToDelete();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodPost();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodPut();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodDelete();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodForChange();

    /**
     * @return FSODirInterface
     * @throws \Exception
     */
    public function getDocumentRoot();

    /**
     * @param FSODirInterface $root
     * @return static
     * @throws \Exception
     */
    public function setDocumentRoot(FSODirInterface $root);
}