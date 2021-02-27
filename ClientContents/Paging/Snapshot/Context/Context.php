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
namespace GI\ClientContents\Paging\Snapshot\Context;

use GI\ClientContents\Paging\Base\Context\AbstractContext;

class Context extends AbstractContext implements ContextInterface
{
    const DEFAULT_SNAPSHOT_SIZE = 10;


    /**
     * @return int
     */
    public function getSize()
    {
        return self::DEFAULT_SNAPSHOT_SIZE;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateSize()
    {
        if (!is_int($this->getSize())) {
            $this->giThrowInvalidTypeException('Size', $this->getSize(), 'integer');
        }

        if ($this->getSize() < 1) {
            $this->giThrowInvalidMinimumException('Size', $this->getSize(), 1);
        }
    }
}