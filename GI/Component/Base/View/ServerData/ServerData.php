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
namespace GI\Component\Base\View\ServerData;

use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable;

use GI\Component\Base\View\ClientAttributes\ClientAttributesInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\Util\TextProcessing\Escaper\HTMLAttribute\EscaperInterface;

class ServerData extends Alterable implements ServerDataInterface
{
    const KEY_ATTRIBUTE = 'gi-server-data';

    const SESSION_KEY   = 'gi-session';


    /**
     * @var ClientAttributesInterface
     */
    private $owner;

    /**
     * @var EscaperInterface
     */
    private $escaper;

    /**
     * ServerData constructor.
     * @param ClientAttributesInterface $owner
     * @throws \Exception
     */
    public function __construct(ClientAttributesInterface $owner)
    {
        parent::__construct();

        $this->owner = $owner;

        $this->escaper = $this->getGiServiceLocator()->getUtilites()->getEscaperFactory()->createHTMLAttribute();
    }

    /**
     * @return ClientAttributesInterface
     */
    protected function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function addSessionId()
    {
        $this->set(static::SESSION_KEY, $this->getGiServiceLocator()->getSessionID());

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public function escapeAndSet(string $key, $value)
    {
        $this->set($key, $this->getEscaper()->escape($value));

        return $this;
    }

    /**
     * @param mixed $value
     * @param string $key
     * @return HiddenInterface
     * @throws \Exception
     */
    protected function createDataHidden($value, string $key)
    {
        $hidden = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createHidden([], $value);

        $hidden->getAttributes()
            ->setDataAttribute(ClientAttributesInterface::ATTRIBUTE_JS_OBJECT, $this->getOwner()->getClientJSObject())
            ->setDataAttribute(static::KEY_ATTRIBUTE, $key);

        return $hidden;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $f = function($value, string $key)
        {
            return $this->createDataHidden($value, $key)->toString();
        };

        return $this->joinPairsWithClosure(PHP_EOL, $f);
    }
}