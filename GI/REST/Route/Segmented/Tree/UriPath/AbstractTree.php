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
namespace GI\REST\Route\Segmented\Tree\UriPath;

use GI\REST\Route\Segmented\Tree\AbstractTree as Base;
use GI\REST\Route\Segmented\UriPath\Formatter\Formatter;

use GI\REST\Route\Segmented\Tree\CLI\TreeInterface as CLITreeInterface;
use GI\REST\Route\Segmented\UriPath\Formatter\FormatterInterface;
use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;
use GI\REST\Route\Segmented\UriPath\UriPathInterface as RoutePathInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Delete\DeleteInterface as PathWithDeleteInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Get\GetInterface as PathWithGetInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Post\PostInterface as PathWithPostInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Put\PutInterface as PathWithPutInterface;

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

        $this->getTemplateClasses()->add(TreeInterface::class)->add(CLITreeInterface::class);
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
     * @param ConstraintsInterface|null $constraints
     * @return RoutePathInterface
     * @throws \Exception
     */
    protected function createUriPath(string $template, ConstraintsInterface $constraints = null)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createUriPath(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }

    /**
     * @param string $template
     * @param ConstraintsInterface|null $constraints
     * @return PathWithDeleteInterface
     * @throws \Exception
     */
    protected function createUriPathWithMethodDelete(string $template, ConstraintsInterface $constraints = null)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createUriPathWithMethodDelete(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }

    /**
     * @param string $template
     * @param ConstraintsInterface|null $constraints
     * @return PathWithGetInterface
     * @throws \Exception
     */
    protected function createUriPathWithMethodGet(string $template, ConstraintsInterface $constraints = null)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createUriPathWithMethodGet(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }

    /**
     * @param string $template
     * @param ConstraintsInterface|null $constraints
     * @return PathWithPostInterface
     * @throws \Exception
     */
    protected function createUriPathWithMethodPost(string $template, ConstraintsInterface $constraints = null)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createUriPathWithMethodPost(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }

    /**
     * @param string $template
     * @param ConstraintsInterface|null $constraints
     * @return PathWithPutInterface
     * @throws \Exception
     */
    protected function createUriPathWithMethodPut(string $template, ConstraintsInterface $constraints = null)
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createUriPathWithMethodPut(
            $this->createRouteTemplate($template), $this->createRouteConstraints($constraints)
        );
    }
}