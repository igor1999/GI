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
namespace GI\Storage\Collection\Behaviour\Service\Parts\BoolStrict;

use GI\Storage\Collection\Behaviour\Option\Parts\BoolStrict\BoolStrictInterface as OptionInterface;

trait BoolStrictTrait
{
    /**
     * @return bool
     */
    public function isStrict()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->isStrict();
    }

    /**
     * @param bool|null $item
     * @return static
     * @throws \Exception
     */
    public function validateStrict(bool $item = null)
    {
        if ($this->isStrict() && !is_bool($item)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Item', $item, 'bool');
        }

        return $this;
    }
}