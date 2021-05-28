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

use GI\ViewModel\AbstractViewModel;
use GI\Component\Authentication\Login\Dialog\ViewModel\Validator\Validator;

use GI\Component\Authentication\Login\Dialog\ViewModel\Validator\ValidatorInterface;

/**
 * Class ViewModel
 * @package GI\Component\Authentication\Login\Dialog\ViewModel
 *
 * @method array getLoginName()
 * @method array getPasswordName()
 * @method array getSaveName()
 */
class ViewModel extends AbstractViewModel implements ViewModelInterface
{
    /**
     * @var string
     */
    private $login = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var bool
     */
    private $save = false;

    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * @extract
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @hydrate
     * @param string $login
     * @return static
     */
    protected function setLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @extract
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @hydrate
     * @param string $password
     * @return static
     */
    protected function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @extract
     * @return bool
     */
    public function isSave()
    {
        return $this->save;
    }

    /**
     * @hydrate
     * @param int $save
     * @return static
     */
    protected function setSave(int $save)
    {
        $this->save = (bool)(int)$save;

        return $this;
    }

    /**
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function getValidator()
    {
        if (!($this->validator instanceof ValidatorInterface)) {
            $this->validator = $this->getGiServiceLocator()->getDependency(ValidatorInterface::class, Validator::class);
        }

        return $this->validator;
    }
}