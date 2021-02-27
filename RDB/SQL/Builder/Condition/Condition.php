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
namespace GI\RDB\SQL\Builder\Condition;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Condition implements ConditionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ConditionListInterface
     */
    private $predicateList;

    /**
     * @var string
     */
    private $placeholder = '';

    /**
     * @var string
     */
    private $predicate = '';

    /**
     * @var \Closure
     */
    private $validator;

    /**
     * @var bool
     */
    private $alt;


    /**
     * Predicate constructor.
     * @param ConditionListInterface $predicateList
     * @param string $placeholder
     * @param string $predicate
     * @param \Closure|null $validator
     * @param bool|null $alt
     */
    public function __construct(
        ConditionListInterface $predicateList, string $placeholder, string $predicate,
        \Closure $validator = null, bool $alt = null)
    {
        $this->predicateList = $predicateList;
        $this->placeholder   = $placeholder;
        $this->predicate     = $predicate;
        $this->validator     = $validator;
        $this->alt           = $alt;
    }

    /**
     * @return ConditionListInterface
     */
    protected function getPredicateList()
    {
        return $this->predicateList;
    }

    /**
     * @return string
     */
    protected function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @return string
     */
    protected function getPredicate()
    {
        return $this->predicate;
    }

    /**
     * @return \Closure
     * @throws \Exception
     */
    protected function getValidator()
    {
        if (!($this->validator instanceof \Closure)) {
            $this->giThrowNotSetException('Predicate validator function');
        }

        return $this->validator;
    }

    /**
     * @return bool
     */
    protected function isAlt()
    {
        return $this->alt;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function build()
    {
        $placeholder = $this->giGetSqlFactory()->createPlaceholderExpression($this->placeholder);

        try {
            $exists = call_user_func($this->getValidator());
        } catch (\Exception $e) {
            $value  = $this->getPredicateList()->getParams()->getOptional($this->placeholder);
            $exists = !empty($value);
        }

        if (!$exists) {
            $alt = is_bool($this->alt) ? $this->alt : $this->getPredicateList()->isAlt();

            $value = $alt ? self::TRUE_PREDICATE : self::FALSE_PREDICATE;
        } else {
            $value = $this->predicate;
        }

        $template = str_replace(
            $placeholder->toString(), $value, $this->getPredicateList()->getBuilder()->getTemplate()
        );
        $this->getPredicateList()->getBuilder()->setTemplate($template);

        return $this;
    }
}