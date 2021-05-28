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
namespace GI\Util\TextProcessing\PSRFormat;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractPrefix implements PrefixInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param string $prefix
     * @param string $method
     * @throws \Exception
     */
    protected function validatePrefix(string $prefix, string $method)
    {
        if (($prefix == self::PREFIX_CREATE_AND_ADD) || ($prefix == self::PREFIX_CREATE_AND_INSERT)) {
            $exists = true;
        } else {
            $constantName = self::PREFIX_OF_PREFIX_CONSTANTS . strtoupper($prefix);

            $exists = $this->getGiServiceLocator()->getClassMeta(PrefixInterface::class)->getStaticConstants()->has($constantName);
        }

        if (empty($exists)) {
            $this->getGiServiceLocator()->throwMagicMethodException($method);
        }
    }
}