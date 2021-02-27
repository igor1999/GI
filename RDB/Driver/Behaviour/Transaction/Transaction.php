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
namespace GI\RDB\Driver\Behaviour\Transaction;

use GI\RDB\Driver\Behaviour\AbstractBehaviour;

class Transaction extends AbstractBehaviour implements TransactionInterface
{
    /**
     * @return static
     */
    public function startTransaction()
    {
        $this->getPdo()->beginTransaction();

        return $this;
    }

    /**
     * @return static
     */
    public function commit()
    {
        $this->getPdo()->commit();

        return $this;
    }

    /**
     * @return static
     */
    public function rollBack()
    {
        $this->getPdo()->rollBack();

        return $this;
    }
}