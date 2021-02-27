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

use GI\Component\Factory\Base\FactoryInterface as BaseInterface;

use GI\Component\Error\AccessDenied\AccessDeniedInterface;
use GI\Component\Error\NotFound\NotFoundInterface;
use GI\Component\Error\ServerError\ServerErrorInterface;

/**
 * Interface FactoryInterface
 * @package GI\Component\Error\Factory
 *
 * @method AccessDeniedInterface createAccessDenied(string $message)
 * @method NotFoundInterface createNotFound(string $message)
 * @method ServerErrorInterface createServerError(string $message)
 */
interface FactoryInterface extends BaseInterface
{

}