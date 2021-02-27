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
namespace GI\Component\Error\Factory;

use GI\Component\Factory\Base\AbstractFactory;

use GI\Component\Error\AccessDenied\AccessDenied;
use GI\Component\Error\NotFound\NotFound;
use GI\Component\Error\ServerError\ServerError;


use GI\Component\Error\AccessDenied\AccessDeniedInterface;
use GI\Component\Error\NotFound\NotFoundInterface;
use GI\Component\Error\ServerError\ServerErrorInterface;

/**
 * Class Factory
 * @package GI\Component\Error\Factory
 *
 * @method AccessDeniedInterface createAccessDenied(string $message)
 * @method NotFoundInterface createNotFound(string $message)
 * @method ServerErrorInterface createServerError(string $message)
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->set(AccessDenied::class)
            ->set(NotFound::class)
            ->set(ServerError::class);
    }
}