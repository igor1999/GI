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
namespace GI\Debugging\Handler\View;

use GI\Debugging\Base\View\AbstractView as Base;

use GI\Debugging\Tracing\Tracing\TracingInterface;

/**
 * Class View
 * @package GI\Debugging\Handler\View
 *
 *
 * @method bool isExceptionType()
 * @method ViewInterface setExceptionType(bool $exceptionType)
 * @method string getTitle()
 * @method ViewInterface setTitle(string $title)
 * @method bool hasThrowableClass()
 * @method string getThrowableClass()
 * @method ViewInterface setThrowableClass(string $class)
 * @method bool hasExceptionCaller()
 * @method string getExceptionCaller()
 * @method ViewInterface setExceptionCaller(string $class)
 *
 * @method TracingInterface getTracing()
 * @method ViewInterface setTracing(TracingInterface $tracing)
 * @method string getFile()
 * @method ViewInterface setFile(string $errorFile)
 * @method int getLine()
 * @method ViewInterface setLine(int $errorLine)
 * @method int getCode()
 * @method ViewInterface setCode(int $errorNumber)
 * @method string getMessage()
 * @method ViewInterface setMessage(string $errorMessage)
 */
class View extends Base implements ViewInterface
{

}