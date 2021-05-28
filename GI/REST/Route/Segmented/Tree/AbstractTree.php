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
namespace GI\REST\Route\Segmented\Tree;

use GI\Pattern\Factory\AbstractFactory;

use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;
use GI\REST\Route\Segmented\Behaviour\Formatter\FormatterInterface;
use GI\REST\Route\Segmented\SegmentedInterface;

abstract class AbstractTree extends AbstractFactory implements TreeInterface
{
    /**
     * AbstractTree constructor.
     */
    public function __construct()
    {
        $this->setPrefixToGet()->setCached(true);
    }

    /**
     * @throws \Exception
     */
    public function getParent()
    {
        $this->getGiServiceLocator()->throwNotSetException('Parent tree');
    }

    /**
     * @return string
     */
    abstract protected function getTemplate();

    /**
     * @return ConstraintsInterface
     */
    protected function getConstraints()
    {
        return $this->getGiServiceLocator()->getRouteFactory()->createConstraints();
    }

    /**
     * @return FormatterInterface
     */
    abstract protected function getFormatter();

    /**
     * @return string[]
     */
    public function getPreviousTemplates()
    {
        try {
            $result = $this->getParent()->getPreviousTemplates();
            $result[] = $this->getTemplate();
        } catch (\Exception $e) {
            $result = [$this->getTemplate()];
        }

        return $result;
    }

    /**
     * @return ConstraintsInterface
     */
    public function getPreviousConstraints()
    {
        try {
            $result = $this->getParent()->getPreviousConstraints();
            $result->import($this->getConstraints());
        } catch (\Exception $e) {
            $result = $this->getConstraints();
        }

        return $result;
    }

    /**
     * @param string $template
     * @return string
     */
    protected function createRouteTemplate(string $template)
    {
        $templates = $this->getPreviousTemplates();
        $templates[] = $template;

        if (!$this->getFormatter()->getDirection()) {
            $templates = array_reverse($templates);
        }

        return $this->getFormatter()->compile($templates);
    }

    /**
     * @param ConstraintsInterface|null $constraints
     * @return ConstraintsInterface
     * @throws \Exception
     */
    protected function createRouteConstraints(ConstraintsInterface $constraints = null)
    {
        $result = $this->getPreviousConstraints();

        if ($constraints instanceof ConstraintsInterface) {
            $result->merge($constraints);
        }

        return $result;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed|string
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $result = parent::__call($method, $arguments);
        } catch (\Exception $e) {
            $parser  = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser();
            $builder = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder();

            list($routeName, $params) = $parser->parseBuildWithArgumentList($method);
            $getter = $builder->buildGet($routeName);

            if (!method_exists($this, $getter)) {
                $this->getGiServiceLocator()->throwMagicMethodException($method);
            }

            $route = call_user_func([$this, $getter]);

            if ($route instanceof SegmentedInterface) {
                $result = $route->build($this->createBuildArguments($params, $arguments));
            } else {
                $result = null;
                $this->getGiServiceLocator()->throwInvalidTypeException('Result of method', $method, 'route');
            }
        }

        return $result;
    }

    /**
     * @param array $params
     * @param array $arguments
     * @return array
     * @throws \Exception
     */
    protected function createBuildArguments(array $params, array $arguments)
    {
        if (count($params) != count($arguments)) {
            $this->getGiServiceLocator()->throwCommonException('Number of params failed');
        }

        return array_combine($params, $arguments);
    }
}