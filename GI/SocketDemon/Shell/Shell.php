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
namespace GI\SocketDemon\Shell;

use GI\CLI\CommandLine\CommandLine;

use GI\SocketDemon\Exchange\Request\RequestInterface;
use GI\SocketDemon\Exchange\Response\Collection\CollectionInterface as ResponseCollectionInterface;

class Shell extends CommandLine implements ShellInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseCollectionInterface
     * @throws \Exception
     */
    public function send(RequestInterface $request)
    {
        $this->clean();

        foreach ($request->extract() as $name => $value) {
            $base64 = in_array($name, ['session', 'data']);

            $this->createAndAddNamed($name, $value, $base64);
        }

        $response = $this->getExecutionProcessor()->getJSON();

        return $this->giGetSocketDemonFactory()->createResponseCollection()->fill($response);
    }
}