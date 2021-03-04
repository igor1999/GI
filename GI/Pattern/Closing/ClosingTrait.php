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
namespace GI\Pattern\Closing;

trait ClosingTrait
{
    /**
     * @var bool
     */
    private $closed = false;


    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     * @return static
     */
    protected function setClosed(bool $closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function validateClosing()
    {
        if ($this->isClosed()) {
            throw new Exception($this);
        }

        return $this;
    }
}