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
namespace GI\Util\DI\Interfaces;

use GI\Util\Crypt\Password\Encriptor\EncriptorInterface as PasswordEncriptorInterface;
use GI\Util\Crypt\Password\Verifier\VerifierInterface as PasswordVerifierInterface;
use GI\Util\Crypt\Random\Hash\HashInterface as RandomHashGeneratorInterface;
use GI\Util\Crypt\Random\Word\WordInterface as RandomWordGeneratorInterface;

interface CryptInterface
{
    /**
     * @param string|null $caller
     * @return PasswordEncriptorInterface
     */
    public function getPasswordEncriptor(string $caller = null);

    /**
     * @param string|null $caller
     * @return PasswordVerifierInterface
     */
    public function getPasswordVerifier(string $caller = null);

    /**
     * @param string|null $caller
     * @return RandomHashGeneratorInterface
     */
    public function getRandomHashGenerator(string $caller = null);

    /**
     * @param string|null $caller
     * @return RandomWordGeneratorInterface
     */
    public function createRandomWordGenerator(string $caller = null);
}
