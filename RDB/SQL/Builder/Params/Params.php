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
namespace GI\RDB\SQL\Builder\Params;

use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable;

use GI\RDB\SQL\Builder\BuilderInterface;
use GI\RDB\SQL\Cortege\CortegeInterface;

class Params extends Alterable implements ParamsInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;


    /**
     * Params constructor.
     * @param BuilderInterface $builder
     * @throws \Exception
     */
    public function __construct(BuilderInterface $builder)
    {
        parent::__construct();

        $this->builder = $builder;
    }

    /**
     * @return BuilderInterface
     */
    protected function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param string $param
     * @param CortegeInterface $cortege
     * @return static
     * @throws \Exception
     */
    public function setCortege(string $param, CortegeInterface $cortege)
    {
        $this->set($param, $cortege->toString());

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function build()
    {
        $template = $this->getBuilder()->getTemplate();

        foreach ($this->getItems() as $param => $value) {
            $placeholder = $this->giGetSqlFactory()->createPlaceholderExpression($param);

            $template = str_replace($placeholder->toString(), $value, $template);
        }

        $this->getBuilder()->setTemplate($template);

        return $this;
    }
}