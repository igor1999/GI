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
namespace GI\CLI\Input;

use GI\CLI\CLIInterface;
use GI\Validator\ValidatorInterface;

interface InputInterface extends CLIInterface
{
    /**
     * @return string
     */
    public function getPrompt();

    /**
     * @param string $prompt
     * @return static
     */
    public function setPrompt(string $prompt);

    /**
     * @return int
     */
    public function getRepeat();

    /**
     * @param int $repeat
     * @return static
     */
    public function setRepeat(int $repeat);

    /**
     * @return int
     */
    public function getAttempt();

    /**
     * @return string
     */
    public function getInput();

    /**
     * @return ValidatorInterface
     */
    public function getValidator();

    /**
     * @param ValidatorInterface|null $validator
     * @return static
     */
    public function setValidator(ValidatorInterface $validator = null);

    /**
     * @return static
     */
    public function read();
}