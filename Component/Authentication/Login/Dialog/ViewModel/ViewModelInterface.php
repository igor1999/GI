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
namespace GI\Component\Authentication\Login\Dialog\ViewModel;

use GI\ViewModel\ViewModelInterface as BaseInterface;
use GI\ViewModel\Validator\ValidatorAwareInterface;
use GI\Component\Authentication\Login\Dialog\ViewModel\Validator\ValidatorInterface;

/**
 * Interface ViewModelInterface
 * @package GI\Component\Authentication\Login\Dialog\ViewModel
 *
 * @method array getLoginName()
 * @method array getPasswordName()
 * @method array getSaveName()
 */
interface ViewModelInterface extends BaseInterface, ValidatorAwareInterface
{
    /**
     * @return string
     */
    public function getLogin();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @extract
     * @return bool
     */
    public function isSave();

    /**
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function getValidator();
}