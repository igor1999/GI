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
namespace GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Methods;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Base\AbstractView as Base;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Getter\View as GetterView;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Getter\ViewInterface as GetterViewInterface;
use GI\RDB\Meta\Column\ColumnInterface;

class View extends Base implements ViewInterface
{
    /**
     * @var GetterViewInterface
     */
    private $getterView;


    /**
     * View constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->getterView = $this->giGetDi(GetterViewInterface::class, GetterView::class);
    }

    /**
     * @return GetterViewInterface
     */
    public function getGetterView()
    {
        return $this->getterView;
    }

    /**
     * @param string $namespace
     * @return static
     */
    public function setORMNamespace(string $namespace)
    {
        $this->getGetterView()->setORMNamespace($namespace);

        return $this;
    }

    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function getAccess(ColumnInterface $column)
    {
        return $column->isIdentity() ? 'protected' : 'public';
    }
}