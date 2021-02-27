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
namespace GI\Validator\Simple\ArrayContents;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class InArray extends AbstractSimple implements InArrayInterface
{
    const ARRAY_STRING_SEPARATOR = ', ';


    /**
     * @var array
     */
    private $array;


    /**
     * InArray constructor.
     * @param array $array
     * @param string $validatedParam
     */
    public function __construct(array $array, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->array = $array;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @param array $array
     * @return static
     */
    public function setArray(array $array)
    {
        $this->array = $array;

        return $this;
    }

    /**
     * @message
     * @return string
     */
    protected function getArrayAsString()
    {
        return implode(static::ARRAY_STRING_SEPARATOR, $this->array);
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        return in_array($this->getSource(), $this->array);
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->giTranslate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::IS_IN_ARRAY
        );
    }
}