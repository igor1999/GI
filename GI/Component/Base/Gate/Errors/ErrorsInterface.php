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
namespace GI\Component\Base\Gate\Errors;

use GI\Component\Base\Gate\Errors\ThrowableErrors\ThrowableErrorsInterface;
use GI\REST\Response\ResponseInterface;

interface ErrorsInterface
{
    /**
     * @param string $throwable
     * @return bool
     */
    public function has(string $throwable);

    /**
     * @param string $throwable
     * @return ThrowableErrorsInterface
     * @throws \Exception
     */
    public function get(string $throwable);

    /**
     * @return ThrowableErrorsInterface[]
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
     * @param string $throwable
     * @param string|null $caller
     * @return ResponseInterface
     * @throws \Exception
     */
    public function find(string $throwable, string $caller = null);

    /**
     * @param \Throwable $throwable
     * @return ResponseInterface
     * @throws \Exception
     */
    public function findByThrowable(\Throwable $throwable);

    /**
     * @param string $throwable
     * @param ResponseInterface $response
     * @param string|null $caller
     * @param bool $forCallerInherits
     * @return static
     */
    public function create(
        string $throwable, ResponseInterface $response, string $caller = null, bool $forCallerInherits = false);

    /**
     * @param string $interface
     * @return bool
     */
    public function remove(string $interface);

    /**
     * @return static
     */
    public function clean();
}