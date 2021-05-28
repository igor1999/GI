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
namespace GI\REST\Route\Segmented\Tree\Host;

use GI\REST\Route\Segmented\Tree\AbstractTree as Base;
use GI\REST\Route\Segmented\Host\Formatter\Formatter;

use GI\REST\Route\Segmented\Host\Formatter\FormatterInterface;
use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;
use GI\REST\Route\Segmented\Host\HostInterface as RouteHostInterface;
use GI\REST\Route\Segmented\Host\Advanced\HTTP\HTTPInterface as HostWithHTTPInterface;
use GI\REST\Route\Segmented\Host\Advanced\HTTPS\HTTPSInterface as HostWithHTTPSInterface;

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
     * @return FormatterInterface
     * @throws \Exception
     */
    protected function getFormatter()
    {
        if (!($this->formatter instanceof FormatterInterface)) {
            $this->formatter = $this->getGiServiceLocator()->getDependency(FormatterInterface::class, Formatter::class);
        }

        return $this->formatter;
    }

    /**
     * @param string $template
     * @param ConstraintsInterface $constraints
     * @return RouteHostInterface
     * @throws \Exception
     */
    protected function createHost(string $template, ConstraintsInterface $constraints)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createHost(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }

    /**
     * @param string $template
     * @param ConstraintsInterface $constraints
     * @return HostWithHTTPInterface
     * @throws \Exception
     */
    protected function createHostWithHTTP(string $template, ConstraintsInterface $constraints)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createHostWithHTTP(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }

    /**
     * @param string $template
     * @param ConstraintsInterface $constraints
     * @return HostWithHTTPSInterface
     * @throws \Exception
     */
    protected function createHostWithHTTPS(string $template, ConstraintsInterface $constraints)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createHostWithHTTPS(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }
}