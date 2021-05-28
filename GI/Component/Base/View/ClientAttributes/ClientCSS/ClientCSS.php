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
namespace GI\Component\Base\View\ClientAttributes\ClientCSS;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class ClientCSS implements ClientCSSInterface
{
    use ServiceLocatorAwareTrait;


    const CLIENT_CSS_CONST = 'CLIENT_CSS';

    const SEPARATOR        = ' ';


    /**
     * @var string[]
     */
    private static $cache = [];

    /**
     * @var string
     */
    private $class = '';


    /**
     * ClientCSS constructor.
     * @param string $class
     * @throws \Exception
     */
    public function __construct(string $class)
    {
        $this->class = $class;

        if (!array_key_exists($this->class, self::$cache)) {
            self::$cache[$this->class] = $this->create();
        }
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function create()
    {
        $parents = $this->getGiServiceLocator()->getClassMeta($this->class)->getParents();

        try {
            $constants = [$parents->getOwner()->getSelfConstants()->get(static::CLIENT_CSS_CONST)->getValue()];
        } catch (\Exception $e) {
            $constants = [];
        }

        foreach ($parents->getItems() as $item) {
            try {
                array_unshift($constants, $item->getSelfConstants()->get(static::CLIENT_CSS_CONST)->getValue());
            } catch (\Exception $e) {}
        }

        $constants = array_unique($constants);

        return implode(static::SEPARATOR, $constants);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return self::$cache[$this->class];
    }
}
