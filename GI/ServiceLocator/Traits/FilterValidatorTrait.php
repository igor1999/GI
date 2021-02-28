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
namespace GI\ServiceLocator\Traits;

use GI\Filter\Factory\Factory as FilterFactory;
use GI\Validator\Factory\Factory as ValidatorFactory;

use GI\ServiceLocator\ServiceLocatorInterface;
use GI\Filter\Factory\FactoryInterface as FilterFactoryInterface;
use GI\Validator\Factory\FactoryInterface as ValidatorFactoryInterface;

trait FilterValidatorTrait
{
    /**
     * @var FilterFactoryInterface
     */
    private $filterFactory;

    /**
     * @var ValidatorFactoryInterface
     */
    private $validatorFactory;


    /**
     * @param string|null $caller
     * @return FilterFactoryInterface
     */
    public function getFilterFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(FilterFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->filterFactory instanceof FilterFactoryInterface)) {
                $this->filterFactory = new FilterFactory();
            }

            $result = $this->filterFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return ValidatorFactoryInterface
     */
    public function getValidatorFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(ValidatorFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->validatorFactory instanceof ValidatorFactoryInterface)) {
                $this->validatorFactory = new ValidatorFactory();
            }

            $result = $this->validatorFactory;
        }

        return $result;
    }
}