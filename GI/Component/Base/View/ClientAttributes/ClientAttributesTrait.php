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

use GI\Component\Base\View\ClientAttributes\ClientCSS\ClientCSS;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\DOM\HTML\Element\HTMLInterface;
use GI\Component\Base\View\ClientAttributes\ClientCSS\ClientCSSInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\Component\Base\ComponentInterface;
use GI\Component\Base\View\Siblings\SiblingsInterface;

trait ClientAttributesTrait
{
    /**
     * @var ClientCSSInterface
     */
    private $clientCSS;

    /**
     * @var string
     */
    private $externFormId = '';


    /**
     * @return ClientCSSInterface
     */
    public function getClientCSS()
    {
        if (!($this->clientCSS instanceof ClientCSSInterface)) {
            $this->clientCSS = $this->giGetDi(
                ClientCSSInterface::class, ClientCSS::class, [static::class]
            );
        }

        return $this->clientCSS;
    }

    /**
     * @return string
     */
    public function getClientJSObject()
    {
        return spl_object_hash($this);
    }

    /**
     * @param HTMLInterface $element
     * @param string $id
     * @param bool $withJSClass
     * @return static
     * @throws \Exception
     */
    protected function addClientAttributes(HTMLInterface $element, string $id = '', bool $withJSClass = false)
    {
        $element->getAttributes()
            ->setDataAttribute(static::ATTRIBUTE_CSS, $this->getClientCSS()->toString())
            ->setDataAttribute(static::ATTRIBUTE_JS_OBJECT, $this->getClientJSObject());

        if (!empty($id)) {
            $element->getAttributes()->setDataAttribute(static::ATTRIBUTE_GI_ID, $id);
        }

        if ($withJSClass) {
            $element->getAttributes()->setDataAttribute(static::ATTRIBUTE_JS_CLASS, $this->getClientJSClass());
        }

        return $this;
    }

    /**
     * @param SiblingsInterface $siblings
     * @return static
     * @throws \Exception
     */
    protected function addClientAttributesToSiblings(SiblingsInterface $siblings)
    {
        foreach ($siblings->extract() as $element) {
            $this->addClientAttributes($element);
        }

        return $this;
    }

    /**
     * @param HTMLInterface $element
     * @param string $attribute
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    protected function addObjectSpecifiedAttribute(HTMLInterface $element, string $attribute, $value)
    {
        $element->getAttributes()->set($attribute, $this->buildObjectSpecifiedAttribute($value));

        return $this;
    }

    /**
     * @param HTMLInterface $element
     * @param string $id
     * @return static
     */
    protected function addObjectSpecifiedId(HTMLInterface $element, string $id)
    {
        $element->getAttributes()->setId($this->buildObjectSpecifiedAttribute($id));

        return $this;
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function buildObjectSpecifiedAttribute($value)
    {
        return $this->getClientJSObject() . self::SEPARATOR_FOR_OBJECT_SPECIFIED_ATTRIBUTE . $value;
    }

    /**
     * @param string $relation
     * @param ComponentInterface $relatedObject
     * @return HiddenInterface
     * @throws \Exception
     */
    public function createRelationHidden(string $relation, ComponentInterface $relatedObject)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $hidden = $me->giGetDOMFactory()->getInputFactory()->createHidden();

        $hidden->getAttributes()
            ->setDataAttribute(static::ATTRIBUTE_JS_OBJECT, $this->getClientJSObject())
            ->setDataAttribute(static::ATTRIBUTE_RELATION, $relation)
            ->setDataAttribute(static::ATTRIBUTE_RELATED_OBJECT, $relatedObject->getViewClientJSObject());

        return $hidden;
    }

    /**
     * @return string
     */
    public function getExternFormId()
    {
        return $this->externFormId;
    }

    /**
     * @param string $externFormId
     * @return static
     */
    public function setExternFormId(string $externFormId)
    {
        $this->externFormId = $externFormId;

        return $this;
    }

    /**
     * @return string
     */
    public function createCommonFormId()
    {
        return $this->buildObjectSpecifiedAttribute(self::COMMON_FORM_ID);
    }

    /**
     * @return string
     */
    public function createFormAttribute()
    {
        return empty($this->externFormId) ? $this->createCommonFormId() : $this->externFormId;
    }

    /**
     * @param FormInterface $form
     * @return static
     */
    protected function addCommonFormId(FormInterface $form)
    {
        $form->getAttributes()->setId($this->createCommonFormId());

        return $this;
    }

    /**
     * @param HTMLInterface $element
     * @return static
     */
    protected function addFormAttribute(HTMLInterface $element)
    {
        $element->getAttributes()->setForm($this->createFormAttribute());

        return $this;
    }
}