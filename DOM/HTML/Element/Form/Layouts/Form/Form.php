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
namespace GI\DOM\HTML\Element\Form\Layouts\Form;

use GI\DOM\HTML\Element\Form\Form as BaseForm;

use GI\DOM\HTML\Element\Form\Layouts\Base\LayoutTrait;

class Form extends BaseForm implements FormInterface
{
    use LayoutTrait;


    /**
     * Layout constructor.
     * @param string $method
     * @param string $action
     * @throws \Exception
     */
    public function __construct(string $method = '', string $action = '')
    {
        parent::__construct($method, $action);

        $this->layout = $this->giGetDOMFactory()->createLayout();
    }

    /**
     * @return string
     */
    public function toString()
    {
        $this->getChildNodes()->set($this->getLayout());

        return parent::toString();
    }
}