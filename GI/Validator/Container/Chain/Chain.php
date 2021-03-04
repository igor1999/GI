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
namespace GI\Validator\Container\Chain;

use GI\Validator\Container\AbstractContainer;

use GI\Validator\Container\ContainerTrait;

use GI\Validator\ValidatorInterface;

class Chain extends AbstractContainer implements ChainInterface
{
    use ContainerTrait;


    /**
     * Chain constructor.
     * @param array $contents
     * @param string $validatedParam
     * @throws \Exception
     */
    public function __construct(array $contents = [], string $validatedParam = '')
    {
        parent::__construct($contents);

        $this->setValidatedParam($validatedParam);
    }

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return isset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->giThrowNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @param string|int $index
     * @return ValidatorInterface
     * @throws \Exception
     */
    protected function _get($index)
    {
        return $this->get($index);
    }

    /**
     * @param ValidatorInterface $validator
     * @return static
     */
    public function add(ValidatorInterface $validator)
    {
        $this->items[] = $validator->setValidatedParam($this->getValidatedParam());

        return $this;
    }

    /**
     * @param string|int $index
     * @param ValidatorInterface $validator
     * @return static
     */
    protected function _set($index, ValidatorInterface $validator)
    {
        $this->insert($index, $validator);

        return $this;
    }

    /**
     * @param int $index
     * @param ValidatorInterface $validator
     * @return bool
     */
    public function insert(int $index, ValidatorInterface $validator)
    {
        if ($inserted = $this->has($index)) {
            $validator->setValidatedParam($this->getValidatedParam());
            array_splice($this->items, $index, 0, [$validator]);
        } else {
            $this->add($validator);
        }

        return $inserted;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        if ($deleted = $this->has($index)) {
            array_splice($this->items, $index, 1);
        }

        return $deleted;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        $result = true;

        $value = $this->getSource();

        foreach ($this->items as $item) {
            if (!$item->validate($value)) {
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
     * @return array|string
     * @throws \Exception
     */
    public function getMessages()
    {
        if (!$this->isExists()) {
            $messages = $this->getNoExistenceMessage();
        } else {
            $messages = [];

            foreach ($this->items as $item) {
                if (!$item->getResult()) {
                    $messages[] = $item->getMessages();
                }
            }
        }

        return $messages;
    }

    /**
     * @param string $validatedParam
     * @return static
     */
    public function setValidatedParam(string $validatedParam)
    {
        parent::setValidatedParam($validatedParam);

        $f = function(ValidatorInterface $item) use ($validatedParam)
        {
            $item->setValidatedParam($validatedParam);
        };
        array_map($f, $this->items);

        return $this;
    }
}