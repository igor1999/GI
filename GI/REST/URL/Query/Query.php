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
namespace GI\REST\URL\Query;

use GI\REST\Request\AbstractRequestTree;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\Alterable as Reader;
use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable as Compiler;

use GI\Storage\Collection\StringCollection\HashSet\Alterable\AlterableInterface as ReaderInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\AlterableInterface as CompilerInterface;
use GI\Util\TextProcessing\Escaper\URL\EscaperInterface as URLEscaperInterface;

class Query extends AbstractRequestTree implements QueryInterface
{
    const SEPARATOR = '&';


    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @var CompilerInterface
     */
    private $compiler;

    /**
     * @var URLEscaperInterface
     */
    private $escaper;


    /**
     * @return ReaderInterface
     * @throws \Exception
     */
    protected function getReader()
    {
        if (!($this->reader instanceof ReaderInterface)) {
            $this->reader = $this->getGiServiceLocator()->getDependency(ReaderInterface::class, Reader::class);
        }

        return $this->reader;
    }

    /**
     * @return CompilerInterface|mixed
     * @throws \Exception
     */
    protected function getCompiler()
    {
        if (!($this->compiler instanceof CompilerInterface)) {
            $this->compiler = $this->getGiServiceLocator()->getDependency(CompilerInterface::class, Compiler::class);
        }

        return $this->compiler;
    }

    /**
     * @return URLEscaperInterface
     */
    protected function getEscaper()
    {
        if (!($this->escaper instanceof URLEscaperInterface)) {
            $this->escaper = $this->getGiServiceLocator()->getUtilites()->getEscaperFactory()->createURL();
        }

        return $this->escaper;
    }

    /**
     * @param string $query
     * @return static
     * @throws \Exception
     */
    public function read(string $query)
    {
        $f = function($value)
        {
            return $this->getEscaper()->unescape($value);
        };
        $this->getReader()->read($query, static::SEPARATOR)->map($f);

        $items = $this->getGiServiceLocator()->getUtilites()->getFlatExtractor()
            ->extractWithArrayLikeKeys($this->getReader()->getItems());
        $this->hydrate($items);

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $items = $this->getGiServiceLocator()->getUtilites()->getFlatCreator()
            ->createWithArrayLikeKeys($this->extract());

        $f = function($value)
        {
            return $this->getEscaper()->escape($value);
        };

        return $this->getCompiler()->setItems($items)->map($f)->joinPairs(static::SEPARATOR);
    }
}