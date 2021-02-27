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
namespace GI\Util\Crypt\Password\Encriptor;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\Crypt\Password\Encriptor\Context\ContextInterface;

class Encriptor implements EncriptorInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_ALGORITHM = PASSWORD_BCRYPT;

    const DEFAULT_COST      = 10;


    /**
     * @var string
     */
    private $algorithm = '';

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var int
     */
    private $cost = 0;


    /**
     * Generator constructor.
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);

            $this->algorithm = $context->getAlgorithm();
            $this->options   = $context->getOptions();
            $this->cost      = $context->getBCryptCost();
        } catch (\Exception $e) {
            $this->algorithm = static::DEFAULT_ALGORITHM;
            $this->cost      = static::DEFAULT_COST;
        }
    }

    /**
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param string $algorithm
     * @return static
     */
    protected function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return static
     */
    protected function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     * @return static
     */
    protected function setCost(int $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @param string $password
     * @return string
     */
    public function get(string $password)
    {
        return password_hash($password, $this->algorithm, $this->options);
    }

    /**
     * @param string $password
     * @return string
     */
    public function getDefault(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @return string
     */
    public function getBCrypt(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->cost]);
    }
}