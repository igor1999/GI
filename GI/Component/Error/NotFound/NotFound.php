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
namespace GI\Component\Error\NotFound;

use GI\Component\Error\Base\AbstractError;
use GI\Component\Error\NotFound\View\View;

use GI\Component\Error\NotFound\View\ViewInterface;

class NotFound extends AbstractError implements NotFoundInterface
{
    /**
     * @var ViewInterface
     */
    private $view;


    /**
     * Error constructor.
     * @param string $message
     * @throws \Exception
     */
    public function __construct(string $message)
    {
        parent::__construct($message);

        $this->view = $this->getGiServiceLocator()->getDependency(ViewInterface::class, View::class);
    }

    /**
     * @return ViewInterface
     */
    public function getView()
    {
        return $this->view;
    }
}