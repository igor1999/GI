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
namespace GI\Validator\Simple\Password;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class PasswordsIdentical extends AbstractSimple implements PasswordsIdenticalInterface
{
    /**
     * @var \Closure
     */
    private $password2Finder;


    /**
     * PasswordsIdentical constructor.
     * @param \Closure $password2Finder
     * @param string $validatedParam
     */
    public function __construct(\Closure $password2Finder, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->password2Finder = $password2Finder;
    }

    /**
     * @return \Closure
     */
    public function getPassword2Finder()
    {
        return $this->password2Finder;
    }

    /**
     * @param \Closure $password2Finder
     * @return static
     */
    protected function setPassword2Finder(\Closure $password2Finder)
    {
        $this->password2Finder = $password2Finder;

        return $this;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        return $this->getSource() == call_user_func($this->getPassword2Finder());
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->getGiServiceLocator()->translate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::IS_PASSWORDS_IDENTICAL
        );
    }
}