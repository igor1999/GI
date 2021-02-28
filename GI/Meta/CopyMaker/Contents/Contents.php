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
namespace GI\Meta\CopyMaker\Contents;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ArrayExchangeTrait;
use GI\Pattern\Validation\ValidationTrait;

use GI\Meta\CopyMaker\Registry\RegistryInterface;

class Contents implements ContentsInterface
{
    use ServiceLocatorAwareTrait, ArrayExchangeTrait, ValidationTrait;


    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var string
     */
    private $class = '';

    /**
     * @var string
     */
    private $hash = '';

    /**
     * @var bool
     */
    private $registered = false;

    /**
     * @var \Closure
     */
    private $classEncoder;

    /**
     * @var \Closure
     */
    private $classDecoder;


    /**
     * Contents constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return RegistryInterface
     */
    protected function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @extract class
     * @return string
     */
    protected function getEncodedClass()
    {
        try {
            $class = call_user_func($this->getClassEncoder(), $this->class);
        } catch (\Exception $exception) {
            $class = $this->class;
        }

        return $class;
    }

    /**
     * @param string $class
     * @return static
     */
    protected function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @hydrate class
     * @param string $class
     * @return static
     */
    protected function setDecodedClass($class)
    {
        try {
            $class = call_user_func($this->getClassDecoder(), $class);
        } catch (\Exception $exception) {}

        $this->setClass($class);

        return $this;
    }

    /**
     * @extract
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @hydrate
     * @param string $hash
     * @return static
     */
    protected function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @extract
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * @hydrate
     * @param bool $registered
     * @return static
     */
    protected function setRegistered($registered)
    {
        $this->registered = $registered;

        return $this;
    }

    /**
     * @return \Closure
     * @throws \Exception
     */
    public function getClassEncoder()
    {
        if (!($this->classEncoder instanceof \Closure)) {
            $this->giThrowNotSetException('Class encoder');
        }

        return $this->classEncoder;
    }

    /**
     * @param \Closure|null $classEncoder
     * @return static
     */
    public function setClassEncoder(\Closure $classEncoder = null)
    {
        $this->classEncoder = $classEncoder;

        return $this;
    }

    /**
     * @return \Closure
     * @throws \Exception
     */
    public function getClassDecoder()
    {
        if (!($this->classDecoder instanceof \Closure)) {
            $this->giThrowNotSetException('Class decoder');
        }

        return $this->classDecoder;
    }

    /**
     * @param \Closure|null $classDecoder
     * @return static
     */
    public function setClassDecoder(\Closure $classDecoder = null)
    {
        $this->classDecoder = $classDecoder;

        return $this;
    }

    /**
     * @param mixed $object
     * @return static
     * @throws \Exception
     */
    public function fill($object)
    {
        if (!is_object($object)) {
            $this->giThrowInvalidTypeException('Argument', $object, 'object');
        }

        $this->setClass(get_class($object))
            ->setHash(spl_object_hash($object))
            ->setRegistered($this->getRegistry()->has($this->hash));

        return $this;
    }

    /**
     * @return static
     */
    public function reset()
    {
        $this->setClass('')->setHash('')->setRegistered(false);

        return $this;
    }

    /**
     * @param array $contents
     * @return static
     */
    public function resetAndHydrate(array $contents)
    {
        $this->reset()->hydrate($contents);

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateClass()
    {
        if (empty($this->class)) {
            $this->giThrowIsEmptyException('Class');
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateHash()
    {
        if (empty($this->hash)) {
            $this->giThrowIsEmptyException('Hash');
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateRegistered()
    {
        if ($this->registered && !$this->getRegistry()->has($this->hash)) {
            $this->giThrowCommonException('Registered is true, but no registered object found');
        }

        if (!$this->registered && $this->getRegistry()->has($this->hash)) {
            $this->giThrowCommonException('Registered is false, but registered object exists');
        }

        if ($this->registered && !$this->getRegistry()->validateClass($this->hash, $this->class)) {
            $this->giThrowCommonException('Given and registered classes are not equal');
        }
    }
}