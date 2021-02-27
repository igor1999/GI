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
namespace GI\ClientContents\Selection\Advanced\OnOff;

use GI\ClientContents\Selection\Single\AbstractImmutableSingle;

use GI\ClientContents\Selection\Advanced\I18n\GlossaryAwareTrait;

use GI\ClientContents\Selection\Item\ItemInterface;

class OnOff extends AbstractImmutableSingle implements OnOffInterface
{
    use GlossaryAwareTrait;


    const ON_VALUE = 'on';

    const ON_TEXT  = 'on';

    const OFF_VALUE  = 'off';

    const OFF_TEXT   = 'off';


    /**
     * YesNo constructor.
     */
    public function __construct()
    {
        $this->set(static::ON_VALUE, static::ON_TEXT)
            ->set(static::OFF_VALUE, static::OFF_TEXT);
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getOn()
    {
        return $this->get(static::ON_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectOn()
    {
        $this->getOn()->setSelected(true);

        return $this;
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getOff()
    {
        return $this->get(static::OFF_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectOff()
    {
        $this->getOff()->setSelected(true);

        return $this;
    }
}