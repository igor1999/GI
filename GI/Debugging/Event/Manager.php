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
namespace GI\Debugging\Event;

use GI\Event\Manager as Base;

class Manager extends Base implements ManagerInterface
{
    const EVENT_BEFORE = 'before';

    const EVENT_AFTER  = 'after';


    /**
     * @param \Closure $handler
     * @return static
     * @throws \Exception
     */
    protected function attachBefore(\Closure $handler)
    {
        $this->attach(static::EVENT_BEFORE, $handler);

        return $this;
    }

    /**
     * @param array $params
     * @return static
     */
    public function fireBefore(array $params = [])
    {
        $this->fire(static::EVENT_BEFORE, $params);

        return $this;
    }

    /**
     * @param \Closure $handler
     * @return static
     * @throws \Exception
     */
    protected function attachAfter(\Closure $handler)
    {
        $this->attach(static::EVENT_AFTER, $handler);

        return $this;
    }

    /**
     * @param array $params
     * @return static
     */
    public function fireAfter(array $params = [])
    {
        $this->fire(static::EVENT_AFTER, $params);

        return $this;
    }
}