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
namespace GI\Component\Authentication\Login\Dialog\ViewModel\Validator;

use GI\Validator\Container\Recursive\Recursive;
use GI\Component\Authentication\Login\Dialog\I18n\Glossary;

use GI\Component\Authentication\Login\Dialog\I18n\GlossaryInterface;
use GI\Validator\Simple\Existence\NotEmptyInterface;

/**
 * Class Validator
 * @package GI\Component\Authentication\Login\Dialog\ViewModel\Validator
 *
 * @method NotEmptyInterface getLogin()
 * @method NotEmptyInterface getPassword()
 */
class Validator extends Recursive implements ValidatorInterface
{
    /**
     * Validator constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $validatedParam = $this->giTranslate(GlossaryInterface::class, Glossary::class, 'login');
        $this->getLogin()->setValidatedParam($validatedParam);

        $validatedParam = $this->giTranslate(GlossaryInterface::class, Glossary::class, 'password');
        $this->getPassword()->setValidatedParam($validatedParam);
    }

    /**
     * @return array
     */
    protected function getContents()
    {
        $factory = $this->giGetValidatorFactory();

        return [
            'login'    => $factory->createNotEmpty(),
            'password' => $factory->createNotEmpty()
        ];
    }
}