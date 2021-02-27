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
namespace GI\Component\Base\Gate\Errors\ThrowableErrors;

use GI\Component\Base\Gate\Errors\Error\ErrorInterface;
use GI\REST\Response\ResponseInterface;

interface ThrowableErrorsInterface
{
    /**
     * @return bool
     */
    public function hasNoCaller();

    /**
     * @return ErrorInterface
     * @throws \Exception
     */
    public function getNoCaller();

    /**
     * @param string $caller
     * @return bool
     */
    public function has(string $caller);

    /**
     * @param string|null $caller
     * @return ErrorInterface
     * @throws \Exception
     */
    public function get(string $caller);

    /**
     * @return ErrorInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param string|null $caller
     * @return ErrorInterface
     * @throws \Exception
     */
    public function find(string $caller = null);

    /**
     * @param ResponseInterface $response
     * @param string|null $caller
     * @param bool $forCallerInherits
     * @return static
     */
    public function create(ResponseInterface $response, string $caller = null, bool $forCallerInherits = false);

    /**
     * @param string|null $caller
     * @return bool
     */
    public function remove(string $caller = null);

    /**
     * @return static
     */
    public function clean();
}