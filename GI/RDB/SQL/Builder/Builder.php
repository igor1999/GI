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
namespace GI\RDB\SQL\Builder;

use GI\RDB\SQL\Builder\Params\Params;
use GI\RDB\SQL\Builder\Condition\ConditionList;
use GI\RDB\SQL\Builder\Part\PartList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\SQL\Builder\Params\ParamsInterface;
use GI\RDB\SQL\Builder\Condition\ConditionListInterface;
use GI\RDB\SQL\Cortege\CortegeInterface;
use GI\RDB\SQL\Cortege\Predicates\PredicatesInterface as PredicateCortegeInterface;
use GI\RDB\SQL\Builder\Part\PartListInterface;

class Builder implements BuilderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $template = '';

    /**
     * @var ParamsInterface
     */
    private $params;

    /**
     * @var ConditionListInterface
     */
    private $predicateList;

    /**
     * @var PartListInterface
     */
    private $partList;


    /**
     * Builder constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->params = $this->getGiServiceLocator()->getDependency(ParamsInterface::class, new Params($this), [$this]);

        $this->predicateList = $this->getGiServiceLocator()->getDependency(ConditionListInterface::class, new ConditionList($this), [$this]);

        $this->partList = $this->getGiServiceLocator()->getDependency(PartListInterface::class, new PartList($this), [$this]);
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return static
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return ParamsInterface
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return ConditionListInterface
     */
    public function getPredicateList()
    {
        return $this->predicateList;
    }

    /**
     * @return PartListInterface
     */
    public function getPartList()
    {
        return $this->partList;
    }

    /**
     * @param string $param
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public function setParam(string $param, $value)
    {
        $this->getParams()->set($param, $value);

        return $this;
    }

    /**
     * @param string $param
     * @param CortegeInterface $cortege
     * @return static
     */
    public function setCortegeAsParam(string $param, CortegeInterface $cortege)
    {
        $this->getParams()->setCortege($param, $cortege);

        return $this;
    }

    /**
     * @param array $params
     * @return static
     */
    public function setPredicateParams(array $params)
    {
        $this->getPredicateList()->setParams($params);

        return $this;
    }

    /**
     * @param bool $alt
     * @return static
     */
    public function setPredicateAlt(bool $alt)
    {
        $this->getPredicateList()->setAlt($alt);

        return $this;
    }

    /**
     * @param string $placeholder
     * @param string $predicate
     * @param \Closure|null $validator
     * @param bool|null $alt
     * @return static
     */
    public function setPredicate(string $placeholder, string $predicate, \Closure $validator = null, bool $alt = null)
    {
        $this->getPredicateList()->setByContents($placeholder, $predicate,  $validator, $alt);

        return $this;
    }

    /**
     * @param string $placeholder
     * @param PredicateCortegeInterface $cortege
     * @param bool|null $alt
     * @return static
     * @throws \Exception
     */
    public function setCortegeByContents(string $placeholder, PredicateCortegeInterface $cortege, bool $alt = null)
    {
        $this->getPredicateList()->setCortegeConditionByContents($placeholder, $cortege, $alt);

        return $this;
    }

    /**
     * @param array $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addOrder(array $value, string $placeholder = '')
    {
        $this->getPartList()->addOrder($value, $placeholder);

        return $this;
    }

    /**
     * @param array $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addGroup(array $value, string $placeholder = '')
    {
        $this->getPartList()->addGroup($value, $placeholder);

        return $this;
    }

    /**
     * @param int $limit
     * @param int|null $offset
     * @param string $placeholder
     * @return static
     */
    public function addLimit(int $limit, int $offset = null, string $placeholder = '')
    {
        $this->getPartList()->addLimit($limit, $offset, $placeholder);

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $this->getPredicateList()->build();
        $this->getPartList()->build();
        $this->getParams()->build();

        return $this->getTemplate();
    }
}