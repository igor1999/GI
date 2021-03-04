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
namespace GI\ViewModel;

use GI\DOM\HTML\Attributes\Name\Name;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ArrayExchangeTrait;

use GI\Filter\Container\Recursive\RecursiveInterface as FilterRecursiveInterface;
use GI\Validator\Container\Recursive\RecursiveInterface as ValidatorRecursiveInterface;
use GI\DOM\HTML\Attributes\Name\NameInterface;
use GI\ViewModel\Filter\FilterAwareInterface;
use GI\ViewModel\Validator\ValidatorAwareInterface;

abstract class AbstractViewModel implements ViewModelInterface
{
    use ServiceLocatorAwareTrait, ArrayExchangeTrait;


    const SUFFIX_FOR_NAME = 'Name';


    /**
     * @var ViewModelInterface
     */
    private $_parent;

    /**
     * @var string
     */
    private $_name = '';

    /**
     * @var NameInterface
     */
    private $nameAttributes;


    /**
     * AbstractViewModel constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->nameAttributes = $this->giGetDi(NameInterface::class, Name::class);
    }

    /**
     * @return NameInterface
     */
    protected function getNameAttributes()
    {
        return $this->nameAttributes;
    }

    /**
     * @return bool
     */
    public function hasViewModelParent()
    {
        return $this->_parent instanceof ViewModelInterface;
    }

    /**
     * @return ViewModelInterface
     * @throws \Exception
     */
    public function getViewModelParent()
    {
        if (!$this->hasViewModelParent()) {
            $this->giThrowNotSetException('Parent view model');
        }

        return $this->_parent;
    }

    /**
     * @param ViewModelInterface $parent
     * @return static
     */
    public function setViewModelParent(ViewModelInterface $parent)
    {
        $this->_parent = $parent;

        return $this;
    }

    /**
     * @return string
     */
    public function getViewModelName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setViewModelName(string $name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getViewModelFullName()
    {
        try {
            $name = $this->getViewModelParent()->getViewModelFullName();
            $name[] = $this->_name;
        } catch (\Exception $exception) {
            $name = [];
        }

        return $name;
    }

    /**
     * @param string $member
     * @return array
     */
    public function getMemberFullName(string $member)
    {
        $name = $this->getViewModelFullName();
        $name[] = $member;

        return $name;
    }

    /**
     * @param string $member
     * @return string
     * @throws \Exception
     */
    public function renderMemberFullName(string $member)
    {
        $this->getNameAttributes()->setItems($this->getMemberFullName($member));

        return $this->getNameAttributes()->renderNameValue();
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return array|string
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $getter = $this->giGetPSRFormatParser()->parseWithPrefixGet($method, static::SUFFIX_FOR_NAME);
        } catch (\Exception $exception) {
            try {
                $render = $this->giGetPSRFormatParser()->parseWithPrefixRender($method, static::SUFFIX_FOR_NAME);
            } catch (\Exception $exception) {
                $this->giThrowMagicMethodException($method);
            }
        }

        $result = null;

        if (!empty($getter)) {
            $this->validateGetter($getter);
            $result = $this->getMemberFullName($getter);
        } elseif (!empty($render)) {
            $this->validateGetter($render);
            $result = $this->renderMemberFullName($render);
        }

        return $result;
    }

    /**
     * @param string $property
     * @throws \Exception
     */
    protected function validateGetter(string $property)
    {
        $getter     = $this->giGetPSRFormatBuilder()->buildGet($property);
        $boolGetter = $this->giGetPSRFormatBuilder()->buildIs($property);

        $hasGetter     = $this->giGetClassMeta()->getMethods()->has($getter);
        $hasBoolGetter = $this->giGetClassMeta()->getMethods()->has($boolGetter);

        if (!$hasGetter && !$hasBoolGetter) {
            $this->giThrowNotFoundException('Getter or bool getter');
        }
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setFilterToParent()
    {
        if (empty($this->_name)) {
            $this->giThrowNotSetException('Model name');
        }

        if (!($this instanceof FilterAwareInterface)) {
            $this->giThrowInvalidTypeException('Model', '', 'FilterAwareInterface');
        }

        $parent = $this->getViewModelParent();
        if (!($parent instanceof FilterAwareInterface)) {
            $this->giThrowInvalidTypeException('Parent model', '', 'FilterAwareInterface');
        }
        $parentFilter = $parent->getFilter();

        if (($parentFilter instanceof FilterRecursiveInterface) && ($this instanceof FilterAwareInterface)) {
            $parentFilter->set($this->_name, $this->getFilter());
        } else {
            $this->giThrowInvalidTypeException('Parent filter', '', 'Recursive filter');
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setValidatorToParent()
    {
        if (empty($this->_name)) {
            $this->giThrowNotSetException('Model name');
        }

        if (!($this instanceof ValidatorAwareInterface)) {
            $this->giThrowInvalidTypeException('Model', '', 'ValidatorAwareInterface');
        }

        $parent = $this->getViewModelParent();
        if (!($parent instanceof ValidatorAwareInterface)) {
            $this->giThrowInvalidTypeException('Parent model', '', 'ValidatorAwareInterface');
        }

        $parentValidator = $parent->getValidator();

        if (($parentValidator instanceof ValidatorRecursiveInterface)
                && ($this instanceof ValidatorAwareInterface)) {
            $parentValidator->set($this->_name, $this->getValidator());
        } else {
            $this->giThrowInvalidTypeException('Parent validator', '', 'Recursive validator');
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setFilterAndValidatorToParent()
    {
        $this->setFilterToParent()->setValidatorToParent();

        return $this;
    }
}