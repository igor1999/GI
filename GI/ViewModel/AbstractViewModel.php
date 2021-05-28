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
use GI\Filter\Container\Recursive\Recursive as FilterRecursive;
use GI\Validator\Container\Recursive\Recursive as ValidatorRecursive;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ArrayExchangeTrait;

use GI\Filter\Container\Recursive\RecursiveInterface as FilterRecursiveInterface;
use GI\Validator\Container\Recursive\RecursiveInterface as ValidatorRecursiveInterface;
use GI\DOM\HTML\Attributes\Name\NameInterface;
use GI\Meta\Method\Collection\ImmutableInterface;

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
     * @var FilterRecursiveInterface
     */
    private $filter;

    /**
     * @var ValidatorRecursiveInterface
     */
    private $validator;


    /**
     * AbstractViewModel constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->nameAttributes = $this->getGiServiceLocator()->getDependency(NameInterface::class, Name::class);
        $this->filter         = $this->getGiServiceLocator()->getDependency(
            FilterRecursiveInterface::class, FilterRecursive::class
        );
        $this->validator      = $this->getGiServiceLocator()->getDependency(
            ValidatorRecursiveInterface::class, ValidatorRecursive::class
        );
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
            $this->getGiServiceLocator()->throwNotSetException('Parent view model');
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
            $getter = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()
                ->parseWithPrefixGet($method, static::SUFFIX_FOR_NAME);
        } catch (\Exception $exception) {
            try {
                $render = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()
                    ->parseWithPrefixRender($method, static::SUFFIX_FOR_NAME);
            } catch (\Exception $exception) {
                $this->getGiServiceLocator()->throwMagicMethodException($method);
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
        $getter     = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildGet($property);
        $boolGetter = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildIs($property);

        $hasGetter     = $this->getGiServiceLocator()->getClassMeta()->getMethods()->has($getter);
        $hasBoolGetter = $this->getGiServiceLocator()->getClassMeta()->getMethods()->has($boolGetter);

        if (!$hasGetter && !$hasBoolGetter) {
            $this->getGiServiceLocator()->throwNotFoundException('Getter or bool getter');
        }
    }

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents)
    {
        $descriptor = ImmutableInterface::HYDRATION_DESCRIPTOR;

        foreach ($this->getGiServiceLocator()->getClassMeta()->getMethods()->findByDescriptorName($descriptor) as $method) {
            $name = $method->getName();

            $key = $method->getDescriptor($descriptor);
            if (empty($key)) {
                try {
                    $key = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixSet($name);
                } catch (\Exception $exception) {}
            }

            if (array_key_exists($key, $contents)) {
                $value = $contents[$key];

                $isNull = $method->getReflection()->getParameters()[0]->allowsNull();
                if ($isNull && is_string($value) && (strlen($value) == 0)) {
                    $value = null;
                }

                $method->execute($this, [$value]);
            }
        }

        return $this;
    }

    /**
     * @return FilterRecursiveInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function filter()
    {
        $this->getFilter()->setInput($this)->execute();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setFilterToParent()
    {
        if (empty($this->_name)) {
            $this->getGiServiceLocator()->throwNotSetException('Model name');
        }

        $parentFilter = $this->getViewModelParent()->getFilter();

        if ($parentFilter instanceof FilterRecursiveInterface) {
            $parentFilter->set($this->_name, $this->getFilter());
        } else {
            $this->getGiServiceLocator()->throwInvalidTypeException('Parent filter', '', 'Recursive filter');
        }

        return $this;
    }

    /**
     * @return ValidatorRecursiveInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return $this->getValidator()->validate($this);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setValidatorToParent()
    {
        if (empty($this->_name)) {
            $this->getGiServiceLocator()->throwNotSetException('Model name');
        }

        $parentValidator = $this->getViewModelParent()->getValidator();

        if ($parentValidator instanceof ValidatorRecursiveInterface) {
            $parentValidator->set($this->_name, $this->getValidator());
        } else {
            $this->getGiServiceLocator()->throwInvalidTypeException('Parent validator', '', 'Recursive validator');
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