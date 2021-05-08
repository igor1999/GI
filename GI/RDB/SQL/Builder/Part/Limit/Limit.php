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
namespace GI\RDB\SQL\Builder\Part\Limit;

use GI\RDB\SQL\Builder\BuilderInterface;
use GI\RDB\SQL\Builder\Part\AbstractPart;

class Limit extends AbstractPart implements LimitInterface
{
    const DEFAULT_PLACEHOLDER = 'limit';


    /**
     * @var int
     */
    private $offset;


    /**
     * Limit constructor.
     * @param BuilderInterface $builder
     * @param int $limit
     * @param int|null $offset
     * @param string $placeholder
     */
    public function __construct(BuilderInterface $builder, int $limit, int $offset = null, string $placeholder = '')
    {
        parent::__construct($builder, $limit, $placeholder);

        $this->offset = $offset;
    }

    /**
     * @return int
     */
    protected function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     * @return static
     */
    protected function setOffset(int $offset = null)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return empty($this->offset) ? 'LIMIT %s' : 'LIMIT %s OFFSET ' . $this->offset;
    }
}