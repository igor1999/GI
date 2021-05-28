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
namespace GI\Component\Locales\Model;

use GI\ClientContents\Menu\Menu;

use GI\ClientContents\Menu\Option\OptionInterface;

class LocalesList extends Menu implements LocalesListInterface
{
    /**
     * LocalesList constructor.
     * @param OptionInterface|null $opener
     * @throws \Exception
     */
    public function __construct(OptionInterface $opener = null)
    {
        parent::__construct($opener);

        $this->create();
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function create()
    {
        foreach ($this->getGiServiceLocator()->createSounding()->getUsedLocalesSoundingList() as $locale => $sounding) {
            $option = $this->createOption($locale)->setTitle($sounding)->setLinkToMock();
            $this->set($option);
        }

        return $this;
    }
}