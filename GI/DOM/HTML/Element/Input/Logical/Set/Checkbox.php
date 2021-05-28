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
namespace GI\DOM\HTML\Element\Input\Logical\Set;

use GI\ClientContents\Selection\Multi\AlterableMultiInterface as OptionsInterface;

class Checkbox extends AbstractSet implements CheckboxInterface
{
    /**
     * @var OptionsInterface
     */
    private $options;


    /**
     * Checkbox constructor.
     * @param array $commonName
     * @param array $options
     * @throws \Exception
     */
    public function __construct(array $commonName, array $options = [])
    {
        parent::__construct($commonName);

        $this->options = $this->getGiServiceLocator()->getClientSelectionFactory()->createAlterableMulti();

        $this->options->setMany($options);
    }

    /**
     * @return OptionsInterface
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param OptionsInterface $options
     * @return static
     */
    public function setOptions(OptionsInterface $options)
    {
        $this->options = $options;

        return $this;
    }
}