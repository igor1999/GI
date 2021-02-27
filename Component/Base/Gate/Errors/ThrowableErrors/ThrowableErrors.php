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
namespace GI\Component\Base\Gate\Errors\ThrowableErrors;

use GI\Component\Base\Gate\Errors\Error\Error;

use GI\REST\Response\ResponseInterface;
use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Base\Gate\Errors\Error\ErrorInterface;

class ThrowableErrors implements ThrowableErrorsInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $throwable = '';

    /**
     * @var ErrorInterface
     */
    private $noCaller;

    /**
     * @var ErrorInterface[]
     */
    private $items = [];


    /**
     * ThrowableErrors constructor.
     * @param string $throwable
     */
    public function __construct(string $throwable)
    {
        $this->throwable = $throwable;
    }

    /**
     * @return string
     */
    protected function getThrowable()
    {
        return $this->throwable;
    }

    /**
     * @param ResponseInterface $response
     * @param bool $forCallerInherits
     * @return ErrorInterface
     */
    protected function createError(ResponseInterface $response, bool $forCallerInherits = false)
    {
        try {
            $result = $this->giGetDi(ErrorInterface::class, null, [$response, $forCallerInherits]);
        } catch (\Exception $exception) {
            $result = new Error($response, $forCallerInherits);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function hasNoCaller()
    {
        return $this->noCaller instanceof ErrorInterface;
    }

    /**
     * @return ErrorInterface
     * @throws \Exception
     */
    public function getNoCaller()
    {
        if (!$this->hasNoCaller()) {
            $this->giThrowNotSetException('No caller error');
        }

        return $this->noCaller;
    }

    /**
     * @param ResponseInterface $response
     * @param bool $forCallerInherits
     * @return static
     */
    protected function createNoCaller(ResponseInterface $response, bool $forCallerInherits = false)
    {
        $this->noCaller = $this->createError($response, $forCallerInherits);

        return $this;
    }

    /**
     * @return static
     */
    protected function removeNoCaller()
    {
        $this->noCaller = null;

        return $this;
    }

    /**
     * @param string $caller
     * @return bool
     */
    public function has(string $caller)
    {
        return isset($this->items[$caller]);
    }

    /**
     * @param string|null $caller
     * @return ErrorInterface
     * @throws \Exception
     */
    public function get(string $caller)
    {
        if (!$this->has($caller)) {
            $this->giThrowNotInScopeException($caller);
        }

        return $this->items[$caller];
    }

    /**
     * @return ErrorInterface[]
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
     * @param string|null $caller
     * @return ErrorInterface
     * @throws \Exception
     */
    public function find(string $caller = null)
    {
        if (empty($caller)) {
            $result = $this->getNoCaller();
        } else {
            try {
                $result = $this->get($caller);
            } catch (\Exception $exception) {
                try {
                    $result = $this->get($this->findAncestor($caller));
                } catch (\Exception $exception) {
                    $result = $this->getNoCaller();
                }
            }
        }

        return $result;
    }

    /**
     * @param string $caller
     * @return string
     * @throws \Exception
     */
    protected function findAncestor(string $caller)
    {
        $f = function(ErrorInterface $item)
        {
            return $item->isForCallerInherits();
        };
        $callers = array_keys(array_filter($this->getItems(), $f));

        $ancestors = $this->giGetClassMeta($caller)->getParents()->getOrderedAncestors($callers);

        return $ancestors->getFirst()->getName();
    }

    /**
     * @param ResponseInterface $response
     * @param string|null $caller
     * @param bool $forCallerInherits
     * @return static
     */
    public function create(ResponseInterface $response, string $caller = null, bool $forCallerInherits = false)
    {
        if (empty($caller)) {
            $this->createNoCaller($response, $forCallerInherits);
        } else {
            $this->items[$caller] = $this->createError($response, $forCallerInherits);
        }

        return $this;
    }

    /**
     * @param string|null $caller
     * @return bool
     */
    public function remove(string $caller = null)
    {
        if (empty($caller)) {
            $this->removeNoCaller();

            $result = true;
        } elseif ($result = $this->has($caller)) {
            unset($this->items[$caller]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->removeNoCaller();

        $this->items = [];

        return $this;
    }
}