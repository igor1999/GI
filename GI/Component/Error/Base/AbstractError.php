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
namespace GI\Component\Error\Base;

use GI\Component\Base\AbstractComponent;

use GI\Component\Error\Base\View\ViewInterface;

abstract class AbstractError extends AbstractComponent implements ErrorInterface
{
    /**
     * @var string
     */
    private $message = '';


    /**
     * Error constructor.
     * @param string $message
     * @throws \Exception
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return ViewInterface
     */
    abstract protected function getView();

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()->setMessage($this->message)->toString();
    }
}