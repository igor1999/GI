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
namespace GI\CLI\Input\Password;

use GI\CLI\Input\AbstractInput;

class Password extends AbstractInput implements PasswordInterface
{
    const MASK_CHAR      = '*';

    const DEFAULT_PROMPT = 'Password: ';


    /**
     * @var bool
     */
    private $done = false;


    /**
     * Password constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setPrompt(static::DEFAULT_PROMPT);
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->done;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function read()
    {
        $this->done = false;

        $this->printPrompt();

        $f = function ($password)
        {
            $this->finish($password);
        };
        readline_callback_handler_install('', $f);

        while (!$this->done) {
            $read = [STDIN];
            $write = $except = null;

            $n = stream_select($read, $write, $except, null);

            if ($n && in_array(STDIN, $read)) {
                readline_callback_read_char();
                echo static::MASK_CHAR;
            }
        }

        readline_callback_handler_remove();

        $this->handleFail();

        return $this;
    }

    /**
     * @param string $password
     * @return static
     */
    protected function finish(string $password)
    {
        $this->done = true;

        $this->setInput($password);

        return $this;
    }
}