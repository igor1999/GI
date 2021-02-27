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
namespace GI\Meta\Method;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Method implements MethodInterface
{
    use ServiceLocatorAwareTrait;


    const DESCRIPTOR_PREFIX            = '@';

    const DESCRIPTOR_REG_EXP           = '/@%s\s+(\S+)(\r|\n|\t)/U';

    const DESCRIPTOR_REG_EXP_DELIMITER = '/';


    /**
     * @var \ReflectionMethod
     */
    private $reflection;


    /**
     * Method constructor.
     * @param \ReflectionMethod $reflection
     */
    public function __construct(\ReflectionMethod $reflection)
    {
        $this->reflection = $reflection;
    }

    /**
     * @return \ReflectionMethod
     */
    public function getReflection()
    {
        return $this->reflection;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflection->getName();
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->reflection->getDeclaringClass()->getName();
    }

    /**
     * @param mixed|null $instance
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function execute($instance = null, array $arguments = [])
    {
        $this->open();
        $value = $this->reflection->isStatic()
            ? $this->reflection->invokeArgs(null, $arguments)
            : $this->reflection->invokeArgs($instance, $arguments);
        $this->close();

        return $value;
    }

    /**
     * @return static
     */
    protected function open()
    {
        if (!$this->reflection->isPublic()) {
            $this->reflection->setAccessible(true);
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function close()
    {
        if (!$this->reflection->isPublic()) {
            $this->reflection->setAccessible(false);
        }

        return $this;
    }

    /**
     * @param string $descriptor
     * @return bool
     */
    public function hasDescriptor(string $descriptor)
    {
        return strpos($this->reflection->getDocComment(), static::DESCRIPTOR_PREFIX . $descriptor) !== false;
    }

    /**
     * @param string $descriptor
     * @return string
     */
    public function getDescriptor(string $descriptor)
    {
        $regExp = sprintf(
            static::DESCRIPTOR_REG_EXP, preg_quote($descriptor, static::DESCRIPTOR_REG_EXP_DELIMITER)
        );

        preg_match($regExp, $this->reflection->getDocComment(), $matches);

        return empty($matches) ? null : $matches[1];
    }
}