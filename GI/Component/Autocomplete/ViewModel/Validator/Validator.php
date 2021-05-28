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
namespace GI\Component\Autocomplete\ViewModel\Validator;

use GI\Validator\Container\Recursive\Recursive;
use GI\Component\Autocomplete\I18n\Glossary;

use GI\Component\Autocomplete\I18n\GlossaryInterface;
use GI\Validator\Simple\Existence\NotEmptyInterface;

/**
 * Class Validator
 * @package GI\Component\Autocomplete\ViewModel\Validator
 *
 * @method NotEmptyInterface getSearch()
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

        $param = $this->getGiServiceLocator()->translate(GlossaryInterface::class, Glossary::class, 'Search');
        $this->getSearch()->setValidatedParam($param);
    }

    /**
     * @return array
     */
    protected function getContents()
    {
        return [
            'search' => $this->getGiServiceLocator()->getValidatorFactory()->createNotEmpty()
        ];
    }
}