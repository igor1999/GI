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
namespace GI\ClientContents\Selection\Advanced\Salutation;

use GI\ClientContents\Selection\Single\AbstractImmutableSingle;

use GI\ClientContents\Selection\Advanced\I18n\GlossaryAwareTrait;
use GI\ClientContents\Selection\Advanced\UnknownTrait;

use GI\ClientContents\Selection\Item\ItemInterface;

class Salutation extends AbstractImmutableSingle implements SalutationInterface
{
    use GlossaryAwareTrait, UnknownTrait;


    const MR_VALUE  = 'Mr';

    const MR_TEXT   = 'Mr.';

    const MRS_VALUE = 'Mrs';

    const MRS_TEXT  = 'Mrs.';


    /**
     * YesNo constructor.
     */
    public function __construct()
    {
        $this->set(static::MR_VALUE, static::MR_TEXT)
            ->set(static::MRS_VALUE, static::MRS_TEXT);
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getMr()
    {
        return $this->get(static::MR_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectMr()
    {
        $this->getMr()->setSelected(true);

        return $this;
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getMrs()
    {
        return $this->get(static::MRS_VALUE);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function selectMrs()
    {
        $this->getMrs()->setSelected(true);

        return $this;
    }
}