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
namespace GI\REST\Route\Segmented\Tree\CLI;

use GI\REST\Route\Segmented\Tree\AbstractTree as Base;
use GI\REST\Route\Segmented\Behaviour\Formatter\Formatter;

use GI\REST\Route\Segmented\Behaviour\Formatter\FormatterInterface;
use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;
use GI\REST\Route\Segmented\CLI\CLIInterface as RouteCLIInterface;

abstract class AbstractTree extends Base implements TreeInterface
{
    /**
     * @var FormatterInterface
     */
    private $formatter;


    /**
     * AbstractTree constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->getTemplateClasses()->add(TreeInterface::class);
    }

    /**
     * @return FormatterInterface|mixed
     * @throws \Exception
     */
    protected function getFormatter()
    {
        if (!($this->formatter instanceof FormatterInterface)) {
            $this->formatter = $this->giGetDi(FormatterInterface::class, Formatter::class);
        }

        return $this->formatter;
    }

    /**
     * @param string $template
     * @param ConstraintsInterface|null $constraints
     * @return RouteCLIInterface
     * @throws \Exception
     */
    protected function createCLI(string $template, ConstraintsInterface $constraints = null)
    {
        return $this->giGetRouteFactory()->createCLI(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }
}