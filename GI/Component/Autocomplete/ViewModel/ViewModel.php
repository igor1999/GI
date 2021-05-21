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
namespace GI\Component\Autocomplete\ViewModel;

use GI\ViewModel\AbstractViewModel;
use GI\Component\Autocomplete\ViewModel\Validator\Validator;

use GI\Component\Autocomplete\ViewModel\Validator\ValidatorInterface;

class ViewModel extends AbstractViewModel implements ViewModelInterface
{
    /**
     * @var string
     */
    private $search = '';

    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * @extract
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @hydrate
     * @param string $search
     * @return static
     */
    protected function setSearch(string $search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function getValidator()
    {
        if (!($this->validator instanceof ValidatorInterface)) {
            $this->validator = $this->giGetDi(ValidatorInterface::class, Validator::class);
        }

        return $this->validator;
    }
}