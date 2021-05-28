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
namespace GI\DOM\HTML\Element\Lists\LinkedList;

use GI\DOM\HTML\Element\Lists\UL\UL;

use GI\DOM\Base\NodeInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;

class LinkedList extends UL implements LinkedListInterface
{
    const KEY_ATTRIBUTE = 'key';


    /**
     * @var array
     */
    private $source = [];


    /**
     * BL constructor.
     * @param array $source
     * @throws \Exception
     */
    public function __construct(array $source)
    {
        parent::__construct();

        if (empty($source)) {
            $this->getGiServiceLocator()->throwIsEmptyException('List source');
        }

        $this->source = $source;

        $this->create();
    }

    /**
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function create()
    {
        $head   = array_slice($this->source, 0, 1, true);
        $keys   = array_keys($head);
        $key    = array_shift($keys);
        $option = array_shift($head);

        $tail  = array_slice($this->source, 1, null, true);

        if ($option instanceof NodeInterface) {
            $context = $option;
        } elseif ($option instanceof StringConvertableInterface) {
            $context = $option->toString();
        } elseif (is_object($option) || is_array($option)) {
            $context = null;
            $this->getGiServiceLocator()->throwInvalidTypeException('Option', $key, 'scalar or string convertable');
        } else {
            $context = $option;
        }

        $li = $this->getGiServiceLocator()->getDOMFactory()->createLI();
        $li->getChildNodes()->set($context);

        try {
            $li->getChildNodes()->add(new static($tail));
        } catch (\Exception $exception) {}

        $this->getAttributes()->setDataAttribute(static::KEY_ATTRIBUTE, $key);
        $this->getChildNodes()->addItem($li);

        return $this;
    }
}