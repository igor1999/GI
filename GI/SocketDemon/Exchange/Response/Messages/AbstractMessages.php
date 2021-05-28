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
namespace GI\SocketDemon\Exchange\Response\Messages;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ExtractionTrait;
use GI\SocketDemon\Exchange\Response\I18n\GlossaryAwareTrait;

abstract class AbstractMessages implements MessagesInterface
{
    use ServiceLocatorAwareTrait, ExtractionTrait, GlossaryAwareTrait;


    /**
     * @extract closed
     * @return string
     */
    protected function getOnClose()
    {
        return $this->translate('Connection closed with code {code} and reason {reason}');
    }

    /**
     * @extract error
     * @return string
     */
    protected function getOnError()
    {
        return $this->translate('Error on connection with message: {message}');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getJSON()
    {
        return $this->getGiServiceLocator()->createJsonEncoder()->extractAndEncode($this);
    }
}