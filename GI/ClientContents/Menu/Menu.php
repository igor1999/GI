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
namespace GI\ClientContents\Menu;

use GI\ClientContents\Menu\Option\Option;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\Menu\Option\OptionInterface;

class Menu implements MenuInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_ID = '_top';


    const OPTION_SEPARATOR = '_';

    const POPUP_PREFIX     = 'Popup';


    /**
     * @var OptionInterface
     */
    private $opener;

    /**
     * @var OptionInterface[]
     */
    private $options = [];


    /**
     * Menu constructor.
     * @param OptionInterface|null $opener
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(OptionInterface $opener = null, array $contents = [])
    {
        $this->opener = $opener;

        if (empty($contents)) {
            $contents = $this->getDefaultContents();
        }

        $this->createContents($contents);
    }

    /**
     * @return bool
     */
    public function hasOwner()
    {
        return $this->opener instanceof OptionInterface;
    }

    /**
     * @return OptionInterface
     * @throws \Exception
     */
    public function getOpener()
    {
        if (!$this->hasOwner()) {
            $this->giThrowNotSetException('Opener');
        }

        return $this->opener;
    }

    /**
     * @return string
     */
    public function getID()
    {
        try {
            $id = $this->getOpener()->getGlobalID();
        } catch (\Exception $e) {
            $id = static::DEFAULT_ID;
        }

        return $id;
    }

    /**
     * @param string $localID
     * @return Option
     */
    protected function createOption($localID)
    {
        try {
            $option = $this->giGetDi(OptionInterface::class, null, [$this, $localID]);
        } catch (\Exception $e) {
            $option = new Option($this, $localID);
        }

        return $option;
    }

    /**
     * @param OptionInterface $owner
     * @param array $contents
     * @return Menu
     * @throws \Exception
     */
    protected function createPopup(OptionInterface $owner, array $contents = [])
    {
        try {
            $popup = $this->giGetDi(MenuInterface::class, null, [$owner, $contents]);
        } catch (\Exception $e) {
            $popup = new Menu($owner, $contents);
        }

        return $popup;
    }

    /**
     * @return array
     */
    protected function getDefaultContents()
    {
        return [];
    }

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    protected function createContents(array $contents)
    {
        $this->clean();

        foreach ($contents as $key => $value)
        {
            if (is_int($key) && is_string($value)) {
                $this->set($this->createOption($value));
            } elseif (is_string($key) && is_array($value)) {
                $option = $this->createOption($key);
                $popup  =$this->createPopup($option, $value);
                $option->setPopup($popup);
                $this->set($option);
            } elseif (is_string($key)
                    && is_string($value)
                    && is_a($value, MenuInterface::class, true)) {
                $option = $this->createOption($key);
                $popup  = new $value($option);
                $option->setPopup($popup);
                $this->set($option);
            } else {
                $this->giThrowInvalidFormatException('Option', $key, 'string/array/MenuInterface');
            }
        }

        return $this;
    }

    /**
     * @param array $keys
     * @return OptionInterface
     * @throws \Exception
     */
    public function getRecursive(array $keys)
    {
        if (empty($keys)) {
            $this->giThrowIsEmptyException('Keys');
        }

        $key    = array_shift($keys);
        $option = $this->get($key);

        if (!empty($keys)) {
            $option = $option->getPopup()->getRecursive($keys);
        }

        return $option;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return MenuInterface|OptionInterface
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $keys  = $this->giGetPSRFormatParser()->parseWithPrefixGet($method, static::POPUP_PREFIX);
            $popup = true;
        } catch (\Exception $exception) {
            try {
                $keys = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
                $popup = false;
            } catch (\Exception $exception) {
                $keys = null;
                $popup = null;
                $this->giThrowMagicMethodException($method);
            }
        }

        $keys = array_filter(explode(static::OPTION_SEPARATOR, $keys));

        $f = function($key)
        {
            return $this->giGetCamelCaseConverter()->convertToHyphenLowerCase($key);
        };
        $keys = array_map($f, $keys);

        $option = $this->getRecursive($keys);

        return $popup ? $option->getPopup() : $option;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->options[$key]);
    }

    /**
     * @param string $key
     * @return OptionInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->options[$key];
    }

    /**
     * @return OptionInterface[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->options);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->options);
    }

    /**
     * @param OptionInterface $option
     * @return static
     * @throws \Exception
     */
    protected function set(OptionInterface $option)
    {
        $this->options[$option->getLocalID()] = $option;

        return $this;
    }

    /**
     * @param string $id
     * @return static
     * @throws \Exception
     */
    protected function setByLocalID(string $id)
    {
        $option = $this->createOption($id);

        $this->set($option);

        return $this;
    }

    /**
     * @param string $anchor
     * @param OptionInterface $option
     * @return static
     * @throws \Exception
     */
    protected function insertBefore(string $anchor, OptionInterface $option)
    {
        $this->options = $this->giGetStorageFactory()
            ->createMixedHashSetAlterable($this->options)
            ->insertBefore($anchor, $option->getLocalID(), $option)
            ->getItems();

        return $this;
    }

    /**
     * @param string $anchor
     * @param string $id
     * @return static
     * @throws \Exception
     */
    protected function insertBeforeByLocalID(string $anchor, string $id)
    {
        $option = $this->createOption($id);

        $this->insertBefore($anchor, $option);

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->options[$key]);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function clean()
    {
        $this->options = [];

        return $this;
    }
}