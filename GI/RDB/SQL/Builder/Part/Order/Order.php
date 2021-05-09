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
namespace GI\RDB\SQL\Builder\Part\Order;

use GI\RDB\SQL\Builder\Part\AbstractPart;
use GI\RDB\SQL\Constants;

use GI\RDB\SQL\Builder\BuilderInterface;

class Order extends AbstractPart implements OrderInterface
{
    const DEFAULT_PLACEHOLDER = 'order';


    const GLUE = ', ';


    /**
     * Order constructor.
     * @param BuilderInterface $builder
     * @param array $fields
     * @param string $placeholder
     * @throws \Exception
     */
    public function __construct(BuilderInterface $builder, array $fields, string $placeholder = '')
    {
        $delimitedFields = [];

        foreach ($fields as $key => $value) {
            $delimitedFields[] = $this->delimitOrderField($key, $value);
        }

        parent::__construct($builder, implode(static::GLUE, $delimitedFields), $placeholder);
    }

    /**
     * @param string|int $key
     * @param string|bool|null $value
     * @return string
     * @throws \Exception
     */
    protected function delimitOrderField($key, $value)
    {
        if (is_string($key) && is_bool($value)) {
            $direction = $value ? '' : ' '. Constants::ORDER_DESC_MODIFICATOR;
            $field     = $this->delimitField($key) . $direction;
        } elseif (is_string($key) && !is_bool($value)) {
            $field = $this->delimitField($key);
        } else {
            $field = $this->delimitField($value);
        }

        return $field;
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'ORDER BY %s';
    }
}