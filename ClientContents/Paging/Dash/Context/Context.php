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
namespace GI\ClientContents\Paging\Dash\Context;

use GI\ClientContents\Paging\Base\Context\AbstractContext;

class Context extends AbstractContext implements ContextInterface
{
    const DEFAULT_FRONT_PART = 3;

    const DEFAULT_REACH      = 1;

    const DEFAULT_BACK_PART  = 3;


    /**
     * @return int
     */
    public function getFrontPart()
    {
        return self::DEFAULT_FRONT_PART;
    }

    /**
     * @return int
     */
    public function getReach()
    {
        return self::DEFAULT_REACH;
    }

    /**
     * @return int
     */
    public function getBackPart()
    {
        return self::DEFAULT_BACK_PART;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateFrontPart()
    {
        if (!is_int($this->getFrontPart())) {
            $this->giThrowInvalidTypeException('Front Part', $this->getFrontPart(), 'integer');
        }

        if ($this->getFrontPart() < 1) {
            $this->giThrowInvalidMinimumException('Front Part', $this->getFrontPart(), 1);
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateReach()
    {
        if (!is_int($this->getReach())) {
            $this->giThrowInvalidTypeException('Reach', $this->getReach(), 'integer');
        }

        if ($this->getReach() < 1) {
            $this->giThrowInvalidMinimumException('Reach', $this->getReach(), 1);
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateBackPart()
    {
        if (!is_int($this->getBackPart())) {
            $this->giThrowInvalidTypeException('Back Part', $this->getBackPart(), 'integer');
        }

        if ($this->getBackPart() < 1) {
            $this->giThrowInvalidMinimumException('Back Part', $this->getBackPart(), 1);
        }
    }
}