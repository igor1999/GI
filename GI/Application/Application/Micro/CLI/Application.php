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
namespace GI\Application\Application\Micro\CLI;

use GI\Application\Application\AbstractApplication;

use GI\Application\Application\Base\CLITrait;

use GI\Application\Call\CLI\CallInterface as CLICallInterface;

class Application extends AbstractApplication implements ApplicationInterface
{
    use CLITrait;


    /**
     * @var CLICallInterface[]
     */
    private $calls = [];


    /**
     * @param CLICallInterface $call
     * @return static
     */
    public function add(CLICallInterface $call)
    {
        $this->calls[] = $call;

        return $this;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->calls = [];

        return $this;
    }

    /**
     * @return CLICallInterface[]
     */
    protected function getCalls()
    {
        return $this->calls;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function run()
    {
        $found = false;

        foreach ($this->calls as $call) {
            $found = $call->handle();

            if ($found) {
                break;
            }
        }

        if (!$found) {
            $this->handleDefault();
        }

        return $found;
    }
}