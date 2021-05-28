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
namespace GI\SocketDemon\Exchange\Request\Common;

use GI\SocketDemon\Exchange\Request\AbstractSingle;

class Common extends AbstractSingle implements CommonInterface
{
    /**
     * @var string
     */
    private $data = '';


    /**
     * @extract
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @hydrate
     * @param string $data
     * @return static
     */
    public function setData(string $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateData()
    {
        if (empty($this->data) || !is_scalar($this->data)) {
            $this->getGiServiceLocator()->throwNotSetException('Request data');
        }
    }
}