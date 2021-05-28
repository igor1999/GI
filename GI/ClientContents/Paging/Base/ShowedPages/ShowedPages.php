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
namespace GI\ClientContents\Paging\Base\ShowedPages;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class ShowedPages implements ShowedPagesInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var int
     */
    private $firstPage;

    /**
     * @var int
     */
    private $lastPage;

    /**
     * @var int
     */
    private $selectedPage;

    /**
     * @var self
     */
    private $next;


    /**
     * ShowedPages constructor.
     *
     * @param int $firstPage
     * @param int $lastPage
     * @param int $selectedPage
     * @throws \Exception
     */
    public function __construct(int $firstPage, int $lastPage, int $selectedPage = 1)
    {
        if ($firstPage <= 0) {
            $this->getGiServiceLocator()->throwInvalidTypeException('First page', $firstPage, 'positive');
        }
        $this->firstPage = $firstPage;

        if ($lastPage < $this->firstPage) {
            $this->getGiServiceLocator()->throwInvalidMinimumException('Last page', $lastPage, $this->firstPage);
        }
        $this->lastPage = $lastPage;

        if ((($selectedPage >= $this->firstPage)) && ($selectedPage <= $this->lastPage)) {
            $this->selectedPage = $selectedPage;
        }
    }

    /**
     * @return int
     */
    public function getFirstPage()
    {
        return $this->firstPage;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * @return int
     */
    public function getSelectedPage()
    {
        return $this->selectedPage;
    }

    /**
     * @return int
     */
    public function hasSelectedPage()
    {
        return !empty($this->selectedPage);
    }

    /**
     * @return static
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param ShowedPagesInterface|null $next
     * @return static
     */
    public function setNext(ShowedPagesInterface $next = null)
    {
        $this->next = $next;

        return $this;
    }
}