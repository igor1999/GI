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
namespace GI\Validator\Simple\Email;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class EmailsIdentical extends AbstractSimple implements EmailsIdenticalInterface
{
    /**
     * @var \Closure
     */
    private $email2Finder;


    /**
     * EmailsIdentical constructor.
     * @param \Closure $email2Finder
     * @param string $validatedParam
     */
    public function __construct(\Closure $email2Finder, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->email2Finder = $email2Finder;
    }

    /**
     * @return \Closure
     */
    public function getEmail2Finder()
    {
         return $this->email2Finder;
    }

    /**
     * @param \Closure $email2Finder
     * @return static
     */
    protected function setEmail2Finder(\Closure $email2Finder)
    {
        $this->email2Finder = $email2Finder;

        return $this;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        return $this->getSource() == call_user_func($this->getEmail2Finder());
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->getGiServiceLocator()->translate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::IS_EMAILS_IDENTICAL
        );
    }
}