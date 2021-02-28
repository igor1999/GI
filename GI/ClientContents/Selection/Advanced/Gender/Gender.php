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
namespace GI\ClientContents\Selection\Advanced\Gender;

use GI\ClientContents\Selection\Single\AbstractImmutableSingle;

use GI\ClientContents\Selection\Advanced\I18n\GlossaryAwareTrait;
use GI\ClientContents\Selection\Advanced\UnknownTrait;

use GI\ClientContents\Selection\Item\ItemInterface;

class Gender extends AbstractImmutableSingle implements GenderInterface
{
    use GlossaryAwareTrait, UnknownTrait;


    const MALE_VALUE   = 'male';

    const MALE_TEXT    = 'male';

    const FEMALE_VALUE = 'female';

    const FEMALE_TEXT  = 'female';

    const OTHERS_VALUE = 'others';

    const OTHERS_TEXT  = 'others';


    /**
     * YesNo constructor.
     */
    public function __construct()
    {
        $this->set(static::MALE_VALUE, static::MALE_TEXT)
            ->set(static::FEMALE_VALUE, static::FEMALE_TEXT);
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getMale()
    {
        return $this->get(static::MALE_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectMale()
    {
        $this->getMale()->setSelected(true);

        return $this;
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getFemale()
    {
        return $this->get(static::FEMALE_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectFemale()
    {
        $this->getFemale()->setSelected(true);

        return $this;
    }

    /**
     * @return bool
     */
    public function hasOthers()
    {
        return $this->has(static::OTHERS_VALUE);
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getOthers()
    {
        return $this->get(static::OTHERS_VALUE);
    }

    /**
     * @param bool $selected
     * @return static
     */
    public function addOthers(bool $selected = false)
    {
        $this->set(static::OTHERS_VALUE, $this->translate(static::OTHERS_TEXT), $selected);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectOthers()
    {
        $this->getOthers()->setSelected(true);

        return $this;
    }

    /**
     * @return static
     */
    public function removeOthers()
    {
        $this->remove(static::OTHERS_VALUE);

        return $this;
    }
}