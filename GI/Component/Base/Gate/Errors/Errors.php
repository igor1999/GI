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
namespace GI\Component\Base\Gate\Errors;

use GI\Exception\AbstractException;

use GI\Component\Base\Gate\Errors\ThrowableErrors\ThrowableErrors;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Base\Gate\Errors\ThrowableErrors\ThrowableErrorsInterface;
use GI\REST\Response\ResponseInterface;

class Errors implements ErrorsInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ThrowableErrorsInterface[]
     */
    private $items = [];


    /**
     * @param string $throwable
     * @return bool
     */
    public function has(string $throwable)
    {
        return isset($this->items[$throwable]);
    }

    /**
     * @param string $throwable
     * @return ThrowableErrorsInterface
     * @throws \Exception
     */
    public function get(string $throwable)
    {
        if (!$this->has($throwable)) {
            $this->getGiServiceLocator()->throwNotInScopeException($throwable);
        }

        return $this->items[$throwable];
    }

    /**
     * @return ThrowableErrorsInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string $throwable
     * @param string|null $caller
     * @return ResponseInterface
     * @throws \Exception
     */
    public function find(string $throwable, string $caller = null)
    {
        return $this->get($throwable)->find($caller)->getResponse();
    }

    /**
     * @param \Throwable $throwable
     * @return ResponseInterface
     * @throws \Exception
     */
    public function findByThrowable(\Throwable $throwable)
    {
        if ($throwable instanceof AbstractException) {
            $caller = $throwable->getCallerClass();
        } else {
            $caller = null;
        }

        return $this->find(get_class($throwable), $caller);
    }

    /**
     * @param string $throwable
     * @param ResponseInterface $response
     * @param string|null $caller
     * @param bool $forCallerInherits
     * @return static
     */
    public function create(
        string $throwable, ResponseInterface $response, string $caller = null, bool $forCallerInherits = false)
    {
        if (!$this->has($throwable)) {
            $this->items[$throwable] = $this->createThrowableErrors($throwable);
        }

        $this->items[$throwable]->create($response, $caller, $forCallerInherits);

        return $this;
    }

    /**
     * @param string $throwable
     * @return ThrowableErrorsInterface
     */
    protected function createThrowableErrors(string $throwable)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(ThrowableErrorsInterface::class, null, [$throwable]);
        } catch (\Exception $exception) {
            $result = new ThrowableErrors($throwable);
        }

        return $result;
    }

    /**
     * @param string $interface
     * @return bool
     */
    public function remove(string $interface)
    {
        if ($result = $this->has($interface)) {
            unset($this->items[$interface]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }
}