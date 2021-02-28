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
namespace GI\SocketDemon\Exchange\Response\Result\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\SocketDemon\Exchange\Response\Result\AuthConfirm\AuthConfirmInterface;
use GI\SocketDemon\Exchange\Response\Result\AuthReject\AuthRejectInterface;
use GI\SocketDemon\Exchange\Response\Result\SocketAlreadyExists\SocketAlreadyExistsInterface;
use GI\SocketDemon\Exchange\Response\Result\SocketDBFailed\SocketDBFailedInterface;
use GI\SocketDemon\Exchange\Response\Result\SocketExpired\SocketExpiredInterface;
use GI\SocketDemon\Exchange\Response\Result\SocketSessionFailed\SocketSessionFailedInterface;

/**
 * Interface FactoryInterface
 * @package GI\SocketDemon\Exchange\Response\Result\Factory
 *
 * @method AuthConfirmInterface createAuthConfirm()
 * @method AuthRejectInterface createAuthReject()
 * @method SocketAlreadyExistsInterface createSocketAlreadyExists()
 * @method SocketDBFailedInterface createSocketDBFailed()
 * @method SocketExpiredInterface createSocketExpired()
 * @method SocketSessionFailedInterface createSocketSessionFailed()
 */
interface FactoryInterface extends BaseInterface
{

}