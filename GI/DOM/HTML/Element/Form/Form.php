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
namespace GI\DOM\HTML\Element\Form;

use GI\DOM\HTML\Element\ContainerElement;
use GI\FileSystem\ContentTypes;
use GI\REST\Constants\RequestMethods;

class Form extends ContainerElement implements FormInterface
{
    const TAG = 'form';


    const DEFAULT_METHOD = RequestMethods::GET;


    /**
     * Form constructor.
     *
     * @param string $method
     * @param string $action
     * @throws \Exception
     */
    public function __construct(string $method = self::DEFAULT_METHOD, string $action = '')
    {
        parent::__construct(static::TAG);

        $this->setMethod($method)->setAction($action);
    }

    /**
     * @param string $method
     * @return static
     * @throws \Exception
     */
    public function setMethod(string $method)
    {
        if (!in_array($method, [RequestMethods::GET, RequestMethods::POST])) {
            $method = self::DEFAULT_METHOD;
        }

        $this->getAttributes()->setMethod(strtolower($method));

        return $this;
    }

    /**
     * @return static
     */
    public function setMethodToGet()
    {
        $this->getAttributes()->setMethodToGet();

        return $this;
    }

    /**
     * @return static
     */
    public function setMethodToPost()
    {
        $this->getAttributes()->setMethodToPost();

        return $this;
    }

    /**
     * @param string $action
     * @return static
     */
    public function setAction(string $action)
    {
        $this->getAttributes()->setAction($action);

        return $this;
    }

    /**
     * @param string $target
     * @return static
     */
    public function setTarget(string $target)
    {
        $this->getAttributes()->setTarget($target);

        return $this;
    }

    /**
     * @param string $encType
     * @return static
     * @throws \Exception
     */
    public function setEncType(string $encType)
    {
        $this->getAttributes()->set('enctype', $encType);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setEncTypeToUrlEncoded()
    {
        return $this->setEncType('application/x-www-form-urlencoded');
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setEncTypeToFormData()
    {
        return $this->setEncType('multipart/form-data');
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setEncTypeToTextPlain()
    {
        return $this->setEncType(ContentTypes::TEXT);
    }

    /**
     * @return string
     */
    public function toString()
    {
        if ($this->getAttributes()->isMethodEqualPost()) {
            $this->getChildNodes()->insert(0, $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createCSRF());
        }

        return parent::toString();
    }
}