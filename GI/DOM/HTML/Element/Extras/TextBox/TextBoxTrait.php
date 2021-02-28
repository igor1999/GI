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
namespace GI\DOM\HTML\Element\Extras\TextBox;

use GI\DOM\HTML\Element\HTMLInterface;

trait TextBoxTrait
{
    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled)
    {
        if ($this instanceof HTMLInterface) {
            $this->getAttributes()->setDisabled((bool)$disabled);
        } else {
            trigger_error('Class should implement HTMLInterface: ' . static::class, E_USER_ERROR);
        }

        return $this;
    }
    /**
     * @param string $placeholder
     * @return static
     */
    public function setPlaceholder(string $placeholder)
    {
        if ($this instanceof HTMLInterface) {
            $this->getAttributes()->setPlaceholder($placeholder);
        } else {
            trigger_error('Class should implement HTMLInterface: ' . static::class, E_USER_ERROR);
        }

        return $this;
    }

    /**
     * @param int $length
     * @return static
     */
    public function setLength(int $length)
    {
        if ($this instanceof HTMLInterface) {
            $this->getAttributes()->setMaxLength((int)$length);
        } else {
            trigger_error('Class should implement HTMLInterface: ' . static::class, E_USER_ERROR);
        }

        return $this;
    }

    /**
     * @param bool $readOnly
     * @return static
     */
    public function setReadOnly(bool $readOnly)
    {
        if ($this instanceof HTMLInterface) {
            $this->getAttributes()->setReadonly((bool)$readOnly);
        } else {
            trigger_error('Class should implement HTMLInterface: ' . static::class, E_USER_ERROR);
        }

        return $this;
    }
}