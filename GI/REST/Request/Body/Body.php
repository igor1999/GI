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
namespace GI\REST\Request\Body;

use GI\REST\URL\Query\Query;
use GI\Storage\Tree\Tree;

use GI\Pattern\Closing\ClosingTrait;
use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\REST\URL\Query\QueryInterface;
use GI\Markup\Reader\ReaderInterface as XMLReaderInterface;
use GI\REST\Route\Segmented\Tree\TreeInterface;

class Body implements BodyInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    /**
     * @var string
     */
    private $raw = '';

    /**
     * Body constructor.
     * @param string|null $raw
     */
    public function __construct(string $raw = null)
    {
        $this->raw = is_string($raw) ? $raw : file_get_contents('php://input');
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param string $raw
     * @return static
     * @throws \Exception
     */
    public function setRaw(string $raw)
    {
        $this->validateClosing();

        $this->raw = $raw;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function validateRaw()
    {
        if (empty($this->raw)) {
            $this->getGiServiceLocator()->throwIsEmptyException('Raw request body');
        }

        return $this;
    }

    /**
     * @return QueryInterface
     * @throws \Exception
     */
    public function getURLEncodedQuery()
    {
        $this->validateRaw();

        if ($this->getGiServiceLocator()->getRequest()->getHeaders()->isURLEncoded()) {
            try {
                $query = $this->getGiServiceLocator()->getDependency(QueryInterface::class);
            } catch (\Exception $exception) {
                $query = new Query();
            }

            $query->read($this->raw);
        } else {
            $query = null;
            $this->getGiServiceLocator()->throwInvalidTypeException('Request headers content type', '', 'url encoded');
        }

        return $query;
    }

    /**
     * @return TreeInterface
     * @throws \Exception
     */
    public function getJSON()
    {
        $this->validateRaw();

        if ($this->getGiServiceLocator()->getRequest()->getHeaders()->isJSONEncoded()) {
            $items  = $this->giServiceLocator->createJsonDecoder()->decode($this->raw);
            $result = $this->createTree($items);
        } else {
            $result = null;
            $this->getGiServiceLocator()->throwInvalidTypeException('Request headers content type', '', 'JSON encoded');
        }

        return $result;
    }

    /**
     * @return TreeInterface|\SimpleXMLElement
     * @throws \Exception
     */
    public function getXML()
    {
        $this->validateRaw();

        if ($this->getGiServiceLocator()->getRequest()->getHeaders()->isXMLEncoded()) {
            try {
                /** @var XMLReaderInterface $reader */
                $reader = $this->getGiServiceLocator()->getDependency(XMLReaderInterface::class);
                $items  = $reader->readString($this->raw);
                $result = $this->createTree($items);
            } catch (\Exception $exception) {
                $result = new \SimpleXMLElement($this->raw);
            }
        } else {
            $result = null;
            $this->getGiServiceLocator()->throwInvalidTypeException('Request headers content type', '', 'XML encoded');
        }

        return $result;
    }

    /**
     * @param array $items
     * @return TreeInterface
     * @throws \Exception
     */
    protected function createTree(array $items = [])
    {
        try {
            $tree = $this->getGiServiceLocator()->getDependency(TreeInterface::class, null, [$items]);
        } catch (\Exception $exception) {
            $tree = new Tree($items);
        }

        return $tree;
    }
}