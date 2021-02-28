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

use GI\Storage\Collection\MixedCollection\HashSet\Closable\Closable as ClosableHashSet;
use GI\REST\Constants\Protocol;
use GI\REST\Constants\RequestMethods;
use GI\CLI\CommandLine\CommandLine;

use GI\CLI\CommandLine\CommandLineInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;

/**
 * Class Server
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
class Server extends ClosableHashSet implements ServerInterface
{
    /**
     * @var CommandLineInterface
     */
    private $commandLine;


    /**
     * Server constructor.
     * @param array|null $contents
     * @throws \Exception
     */
    public function __construct(array $contents = null)
    {
        if (!is_array($contents)) {
            $contents = $_SERVER;
        }

        $option = $this->giGetStorageFactory()
            ->getOptionFactory()
            ->createMixedHashSet()
            ->setKeyFormatToUnderlineUpperCase();

        parent::__construct($contents, $option);

        $this->commandLine = $this->createCommandLine();

        try {
            $arguments = $this->get('argv');

            if (is_array($arguments)) {
                foreach ($arguments as $argument) {
                    $this->commandLine->createAndAdd($argument);
                }
            }
        } catch (\Exception $e) {}
    }

    /**
     * @return static
     */
    public function close()
    {
        parent::close();

        $this->getCommandLine()->close();

        return $this;
    }

    /**
     * @return CommandLineInterface
     */
    public function getCommandLine()
    {
        return $this->commandLine;
    }

    /**
     * @return CommandLine
     */
    protected function createCommandLine()
    {
        return new CommandLine();
    }

    /**
     * @return bool
     */
    public function isOSWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getRequestPort()
    {
        return (int)$this->get('REQUEST_PORT');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getUri()
    {
        return $this->getRequestScheme() . Protocol::PROTOCOL_AND_HOST_SEPARATOR . $this->getHttpHost();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getUriPath()
    {
        return parse_url($this->get('REQUEST_URI'), PHP_URL_PATH);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToGet()
    {
        $this->setRequestMethod(RequestMethods::GET);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToPost()
    {
        $this->setRequestMethod(RequestMethods::POST);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToPut()
    {
        $this->setRequestMethod(RequestMethods::PUT);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setRequestMethodToDelete()
    {
        $this->setRequestMethod(RequestMethods::DELETE);

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodPost()
    {
        return $this->getRequestMethod() === RequestMethods::POST;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodPut()
    {
        return $this->getRequestMethod() === RequestMethods::PUT;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodDelete()
    {
        return $this->getRequestMethod() === RequestMethods::DELETE;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isRequestMethodForChange()
    {
        return $this->isRequestMethodPost() || $this->isRequestMethodPut() || $this->isRequestMethodDelete();
    }

    /**
     * @return FSODirInterface
     * @throws \Exception
    */
    public function getDocumentRoot()
    {
        return $this->giCreateFSODir($this->get('DOCUMENT_ROOT'));
    }

    /**
     * @param FSODirInterface $root
     * @return static
     * @throws \Exception
     */
    public function setDocumentRoot(FSODirInterface $root)
    {
        $this->set('DOCUMENT_ROOT', $root->getPath());

        return $this;
    }
}