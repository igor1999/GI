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
namespace GI\Validator;

interface ValidatorInterface
{
    /**
     * @return bool
     */
    public function isRequired();

    /**
     * @param bool $required
     * @return static
     */
    public function setRequired(bool $required);

    /**
     * @return bool
     */
    public function hasBreak();

    /**
     * @param bool $break
     * @return static
     */
    public function setBreak(bool $break);

    /**
     * @return string
     */
    public function getValidatedParam();

    /**
     * @param string $validatedParam
     * @return static
     */
    public function setValidatedParam(string $validatedParam);

    /**
     * @return mixed
     */
    public function getSource();

    /**
     * @return bool
     */
    public function isExists();

    /**
     * @return bool
     */
    public function getResult();

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value);

    /**
     * @return bool
     */
    public function validateIfNotExists();

    /**
     * @return array|string
     */
    public function getMessages();

    /**
     * @return array
     */
    public function getMessagesFlat();

    /**
     * @return string
     */
    public function getFirstMessage();

    /**
     * @return array
     * @throws \Exception
     */
    public function getMessagesProParam();
}