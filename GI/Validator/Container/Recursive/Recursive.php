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
namespace GI\Validator\Container\Recursive;

use GI\Validator\Container\AbstractContainer;

use GI\Validator\Container\ContainerTrait;

use GI\Validator\ValidatorInterface;

class Recursive extends AbstractContainer implements RecursiveInterface
{
    use ContainerTrait;


    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @param string $key
     * @return ValidatorInterface
     * @throws \Exception
     */
    protected function _get($key)
    {
        return $this->get($key);
    }

    /**
     * @param string $key
     * @param ValidatorInterface $validator
     * @return static
     */
    public function set(string $key, ValidatorInterface $validator)
    {
        $this->items[$key] = $validator;

        return $this;
    }

    /**
     * @param string $key
     * @param ValidatorInterface $validator
     * @return static
     */
    protected function _set($key, ValidatorInterface $validator)
    {
        return $this->set($key, $validator);
    }

    /**
     * @param bool$required
     * @return static
     */
    public function setRequiredForItems(bool $required)
    {
        $f = function(ValidatorInterface $item) use ($required)
        {
            $item->setRequired($required);
        };
        array_map($f, $this->items);

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
        }

        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function doValidation()
    {
        if (!is_array($this->getSource()) && !is_object($this->getSource())) {
            $this->giThrowInvalidTypeException('Validator source', $this->getSource(), 'array or object');
        }

        $result = true;

        foreach ($this->items as $key => $item) {
            $localResult = is_array($this->getSource())
                ? $this->validateItemByArray($key, $item)
                : $this->validateItemByArrayObject($key, $item);

            if (!$localResult) {
                $result = false;
                if ($item->hasBreak()) {
                    $this->setBreak(true);
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * @param string $key
     * @param ValidatorInterface $item
     * @return bool
     */
    protected function validateItemByArray(string $key, ValidatorInterface $item)
    {
        return array_key_exists($key, $this->getSource())
            ? $item->validate($this->getSource()[$key])
            : $item->validateIfNotExists();
    }

    /**
     * @param string $key
     * @param ValidatorInterface $item
     * @return bool
     * @throws \Exception
     */
    protected function validateItemByArrayObject(string $key, ValidatorInterface $item)
    {
        $methodReflectionList = $this->giGetClassMeta($this->getSource())->getMethods();

        return $methodReflectionList->hasGetter($key)
            ? $item->validate($methodReflectionList->executeGetter($this->getSource(), $key))
            : $item->validateIfNotExists();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getMessages()
    {
        if (!$this->isExists()) {
            $messages = $this->getNoExistenceMessage();
        } else {
            $messages = [];

            foreach ($this->items as $key => $item) {
                if (!$item->getResult()) {
                    $messages[$key] = $item->getMessages();
                }
            }
        }

        return $messages;
    }
}