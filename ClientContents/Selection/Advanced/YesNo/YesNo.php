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
namespace GI\ClientContents\Selection\Advanced\YesNo;

use GI\ClientContents\Selection\Single\AbstractImmutableSingle;

use GI\ClientContents\Selection\Advanced\I18n\GlossaryAwareTrait;
use GI\ClientContents\Selection\Advanced\UnknownTrait;

use GI\ClientContents\Selection\Item\ItemInterface;

class YesNo extends AbstractImmutableSingle implements YesNoInterface
{
    use GlossaryAwareTrait, UnknownTrait;


    const YES_VALUE = 'yes';

    const YES_TEXT  = 'yes';

    const NO_VALUE  = 'no';

    const NO_TEXT   = 'no';


    /**
     * YesNo constructor.
     */
    public function __construct()
    {
        $this->set(static::YES_VALUE, static::YES_TEXT)
            ->set(static::NO_VALUE, static::NO_TEXT);
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getYes()
    {
        return $this->get(static::YES_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectYes()
    {
        $this->getYes()->setSelected(true);

        return $this;
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getNo()
    {
        return $this->get(static::NO_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectNo()
    {
        $this->getNo()->setSelected(true);

        return $this;
    }
}