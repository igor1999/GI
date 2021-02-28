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
namespace GI\REST\Route\Segmented;

use GI\REST\Route\AbstractRoute;
use GI\REST\Route\Segmented\Behaviour\Formatter\Formatter;
use GI\REST\Route\Segmented\Behaviour\Segment\Segment;
use GI\Storage\Collection\StringCollection\HashSet\Closable\Closable as Params;

use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;
use GI\REST\Route\Segmented\Behaviour\Formatter\FormatterInterface;
use GI\REST\Route\Segmented\Behaviour\Segment\SegmentInterface;
use GI\Storage\Collection\StringCollection\HashSet\Closable\ClosableInterface as ParamsInterface;

abstract class AbstractSegmented extends AbstractRoute implements SegmentedInterface
{
    /**
     * @var string
     */
    private $template = '';

    /**
     * @var ConstraintsInterface
     */
    private $constraints;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * @var SegmentInterface[]
     */
    private $segments = [];

    /**
     * @var ParamsInterface
     */
    private $params;

    /**
     * @var string
     */
    private $relativePath = '';

    /**
     * @var bool
     */
    private $relativeMode = false;

    /**
     * AbstractSegmented constructor.
     * @param string $template
     * @param ConstraintsInterface|null $constraints
     * @throws \Exception
     */
    public function __construct(string $template, ConstraintsInterface $constraints = null)
    {
        $this->template = $template;

        $titles = $this->createFormatter()->getFormatter()->parse($template);

        foreach ($titles as $title) {
            $this->segments[] = $this->createSegment($title);
        }

        if ($constraints instanceof ConstraintsInterface) {
            $this->constraints = $constraints;
        } else {
            $this->constraints = $this->giGetRouteFactory()->createConstraints();
        }

        $this->params = $this->giGetDi(ParamsInterface::class, Params::class);
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        $this->getConstraints()->close();
        $this->getParams()->close();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createFormatter()
    {
        $this->formatter = $this->giGetDi(FormatterInterface::class, Formatter::class);

        return $this;
    }

    /**
     * @return FormatterInterface
     */
    protected function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @param string $title
     * @return Segment
     * @throws \Exception
     */
    protected function createSegment(string $title)
    {
        try {
            $segment = $this->giGetDi(SegmentInterface::class);
        } catch (\Exception $e) {
            $segment = new Segment($title);
        }

        return $segment;
    }

    /**
     * @return SegmentInterface[]
     */
    protected function getSegments()
    {
        return $this->segments;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return ConstraintsInterface
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param string $param
     * @param string|\Closure $constraint
     * @return static
     * @throws \Exception
     */
    public function setConstraint(string $param, $constraint)
    {
        $this->getConstraints()->set($param, $constraint);

        return $this;
    }

    /**
     * @return ParamsInterface
     */
    protected function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $param
     * @return bool
     */
    public function hasParam(string $param)
    {
        return $this->getParams()->has($param);
    }

    /**
     * @param string $param
     * @return string
     * @throws \Exception
     */
    public function getParam(string $param)
    {
        return $this->getParams()->get($param);
    }

    /**
     * @return string
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * @param string $relativePath
     * @return static
     * @throws \Exception
     */
    protected function setRelativePath($relativePath)
    {
        $this->validateClosing();

        $this->relativePath = $relativePath;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRelativeMode()
    {
        return $this->relativeMode;
    }

    /**
     * @param bool $relativeMode
     * @return static
     * @throws \Exception
     */
    public function setRelativeMode(bool $relativeMode)
    {
        $this->validateClosing();

        $this->relativeMode = $relativeMode;

        return $this;
    }

    /**
     * @param string $source
     * @return bool
     * @throws \Exception
     */
    public function validateByString(string $source)
    {
        $this->setValid(false)->setSource($source)->setRelativePath('')->getParams()->clean();

        $titles = $this->getFormatter()->parse($source);

        if ($this->relativeMode) {
            try {
                list($titles, $relativePath) = $this->getFormatter()->getTitlesAndRelativePath(
                    $titles, count($this->getSegments())
                );

                $this->setValid($this->validateTitles($titles))->setRelativePath($relativePath);
            } catch (\Exception $e) {}
        } elseif (count($titles) == count($this->getSegments())) {
            $this->setValid($this->validateTitles($titles));
        } else {
            $this->setValid(false);
        }

        return $this->isValid();
    }

    /**
     * @param array $titles
     * @return bool
     * @throws \Exception
     */
    protected function validateTitles(array $titles)
    {
        $f = function($title, SegmentInterface $segment)
        {
            return $segment->validate($title, $this->getConstraints(), $this->getParams());
        };

        $results = array_map($f, $titles, $this->getSegments());

        return array_reduce($results, function($carry, $item) {return $carry && $item;}, true);
    }

    /**
     * @param array $params
     * @return string
     */
    public function build(array $params = [])
    {
        $f = function(SegmentInterface $segment) use ($params)
        {
            return $segment->build($params);
        };

        $parts = array_map($f, $this->getSegments());

        return $this->getFormatter()->compile($parts);
    }
}