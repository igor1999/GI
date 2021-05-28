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
namespace GI\Validator\Simple\StringValidation;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class RegExp extends AbstractSimple implements RegExpInterface
{
    /**
     * @var string
     */
    private $regExp = '';


    /**
     * RegExp constructor.
     * @param string $regExp
     * @param string $validatedParam
     */
    public function __construct(string $regExp, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->regExp = $regExp;
    }

    /**
     * @message
     * @return string
     */
    public function getRegExp()
    {
        return $this->regExp;
    }

    /**
     * @param string $regExp
     * @return static
     */
    public function setRegExp(string $regExp)
    {
        $this->regExp = $regExp;

        return $this;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        return preg_match($this->regExp, $this->getSource());
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->getGiServiceLocator()->translate(GlossaryInterface::class, Glossary::class,DefaultMessages::REGEXP);
    }
}