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
namespace GI\Validator\Simple\Comparison;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class GreaterThan extends AbstractSimple implements GreaterThanInterface
{
    /**
     * @var mixed
     */
    private $minimum;


    /**
     * GreaterThan constructor.
     * @param mixed $minimum
     * @param string $validatedParam
     */
    public function __construct($minimum, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->minimum = $minimum;
    }

    /**
     * @message
     * @return mixed
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param mixed $minimum
     * @return static
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        return $this->getSource() > $this->minimum;
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->getGiServiceLocator()->translate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::GREATER_THAN
        );
    }
}