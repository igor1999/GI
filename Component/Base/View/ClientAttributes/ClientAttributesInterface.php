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
namespace GI\Component\Base\View\ClientAttributes;

use GI\Component\Base\View\ClientAttributes\ClientCSS\ClientCSSInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;

interface ClientAttributesInterface
{
    const ATTRIBUTE_CSS       = 'gi-css';

    const ATTRIBUTE_JS_CLASS  = 'gi-js-class';

    const ATTRIBUTE_JS_OBJECT = 'gi-js-object';

    const ATTRIBUTE_GI_ID     = 'gi-id';


    const ATTRIBUTE_RELATION       = 'gi-relation';

    const ATTRIBUTE_RELATED_OBJECT = 'gi-related-object';


    const SEPARATOR_FOR_OBJECT_SPECIFIED_ATTRIBUTE = '::';


    const RENDERING_DESCRIPTOR = 'render';

    const CREATING_DESCRIPTOR  = 'create';


    const COMMON_FORM_ID = 'form';


    /**
     * @return ClientCSSInterface
     */
    public function getClientCSS();

    /**
     * @return string
     */
    public function getClientJSClass();

    /**
     * @return string
     */
    public function getClientJSObject();

    /**
     * @param string $relation
     * @param ClientAttributesInterface $relatedObject
     * @return HiddenInterface
     * @throws \Exception
     */
    public function createRelationHidden(string $relation, ClientAttributesInterface $relatedObject);

    /**
     * @return string
     */
    public function getExternFormId();

    /**
     * @param string $externFormId
     * @return static
     */
    public function setExternFormId(string $externFormId);

    /**
     * @return string
     */
    public function createCommonFormId();

    /**
     * @return string
     */
    public function createFormAttribute();
}