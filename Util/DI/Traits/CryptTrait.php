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
namespace GI\Util\DI\Traits;

use GI\Util\Crypt\Password\Encriptor\Encriptor as PasswordEncriptor;
use GI\Util\Crypt\Password\Verifier\Verifier as PasswordVerifier;
use GI\Util\Crypt\Random\Hash\Hash as RandomHashGenerator;
use GI\Util\Crypt\Random\Word\Word as RandomWordGenerator;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\Crypt\Password\Encriptor\EncriptorInterface as PasswordEncriptorInterface;
use GI\Util\Crypt\Password\Verifier\VerifierInterface as PasswordVerifierInterface;
use GI\Util\Crypt\Random\Hash\HashInterface as RandomHashGeneratorInterface;
use GI\Util\Crypt\Random\Word\WordInterface as RandomWordGeneratorInterface;

trait CryptTrait
{
    /**
     * @var PasswordEncriptorInterface
     */
    private $passwordEncriptor;

    /**
     * @var PasswordVerifierInterface
     */
    private $passwordVerifier;

    /**
     * @var RandomHashGeneratorInterface
     */
    private $randomHashGenerator;


    /**
     * @param string|null $caller
     * @return PasswordEncriptorInterface
     */
    public function getPasswordEncriptor(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                PasswordEncriptorInterface::class, $caller
            );
        } catch (\Exception $e) {
            if (!($this->passwordEncriptor instanceof PasswordEncriptorInterface)) {
                $this->passwordEncriptor = new PasswordEncriptor();
            }

            $result = $this->passwordEncriptor;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return PasswordVerifierInterface
     */
    public function getPasswordVerifier(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                PasswordVerifierInterface::class, $caller
            );
        } catch (\Exception $e) {
            if (!($this->passwordVerifier instanceof PasswordVerifierInterface)) {
                $this->passwordVerifier = new PasswordVerifier();
            }

            $result = $this->passwordVerifier;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return RandomHashGeneratorInterface
     */
    public function getRandomHashGenerator(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                RandomHashGeneratorInterface::class, $caller
            );
        } catch (\Exception $e) {
            if (!($this->randomHashGenerator instanceof RandomHashGeneratorInterface)) {
                $this->randomHashGenerator = new RandomHashGenerator();
            }

            $result = $this->randomHashGenerator;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return RandomWordGeneratorInterface
     */
    public function createRandomWordGenerator(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                RandomWordGeneratorInterface::class, $caller
            );
        } catch (\Exception $e) {
            $result = new RandomWordGenerator();
        }

        return $result;
    }
}