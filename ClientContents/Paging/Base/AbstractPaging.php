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
namespace GI\ClientContents\Paging\Base;

use GI\ClientContents\Paging\Base\ShowedPages\ShowedPages;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\Paging\Base\ShowedPages\ShowedPagesInterface;

abstract class AbstractPaging implements PagingInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var int
     */
    private $entriesTotal;

    /**
     * @var int
     */
    private $selectedPage;

    /**
     * @var int
     */
    private $entriesProPage;

    /**
     * @var ShowedPagesInterface
     */
    private $showedPages;


    /**
     * AbstractPaging constructor.
     * @param int $entriesTotal
     * @param int $selectedPage
     * @param int|null $entriesProPage
     * @throws \Exception
     */
    public function __construct(int $entriesTotal, int $selectedPage = 1, int $entriesProPage = null)
    {
        $this->getContext()->validateProperties();

        if ($entriesTotal < 0) {
            $this->giThrowInvalidMinimumException('Entries total', $entriesTotal, 0);
        }

        if ($selectedPage <= 0) {
            $this->giThrowInvalidMinimumException('Selected page', $selectedPage, 1);
        }

        if (!is_int($entriesProPage)) {
            $entriesProPage = $this->getContext()->getSizes()->getFirst();
        } elseif (!$this->getContext()->getSizes()->contains($entriesProPage)) {
            $this->giThrowCommonException('Items pro page is out of given sizes');
        }

        $this->entriesTotal   = $entriesTotal;
        $this->entriesProPage = $entriesProPage;
        $this->selectedPage   = !$this->isEmpty() ? min($selectedPage, $this->getPagesTotal()) : 1;

        if ($this->getEntriesTotal() > 0) {
            $this->buildShowedPages();
        }
    }


    /**
     * @return int
     */
    public function getEntriesTotal()
    {
        return $this->entriesTotal;
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
    public function getEntriesProPage()
    {
        return $this->entriesProPage;
    }

    /**
     * @return int
     */
    public function getPagesTotal()
    {
        return ceil($this->entriesTotal / $this->entriesProPage);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->getPagesTotal() == 0;
    }

    /**
     * @return bool
     */
    public function isSingle()
    {
        return $this->getPagesTotal() == 1;
    }

    /**
     * @return bool
     */
    public function isMulti()
    {
        return $this->getPagesTotal() > 1;
    }

    /**
     * @return int
     */
    public function getFirstShowedEntry()
    {
        return ($this->selectedPage - 1) * $this->entriesProPage + 1;
    }

    /**
     * @return int
     */
    public function getLastShowedEntry()
    {
        return min($this->selectedPage * $this->entriesProPage, $this->entriesTotal);
    }

    /**
     * @return bool
     */
    public function isFirst()
    {
        return $this->selectedPage == 1;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getPrevious()
    {
        if ($this->isFirst()) {
            $this->giThrowCommonException('This is the first page');
        }

        return $this->selectedPage - 1;
    }

    /**
     * @return bool
     */
    public function isLast()
    {
        return $this->selectedPage == $this->getPagesTotal();
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getNext()
    {
        if ($this->isLast()) {
            $this->giThrowCommonException('This is the last page');
        }

        return $this->selectedPage + 1;
    }

    /**
     * @return bool
     */
    public function needNaviFirst()
    {
        return $this->isMulti() && !$this->isFirst();
    }

    /**
     * @return bool
     */
    public function needNaviLast()
    {
        return $this->isMulti() && !$this->isLast();
    }

    /**
     * @return bool
     */
    public function needNaviPrevious()
    {
        return $this->isMulti() && !$this->isFirst();
    }

    /**
     * @return bool
     */
    public function needNaviNext()
    {
        return $this->isMulti() && !$this->isLast();
    }

    /**
     * @param int $firstPage
     * @param int $lastPage
     * @param int $selectedPage
     * @return ShowedPagesInterface
     * @throws \Exception
     */
    protected function createShowedPages(int $firstPage, int $lastPage, int $selectedPage)
    {
        try {
            $result =$this->giGetDi(
                ShowedPagesInterface::class, null, [$firstPage, $lastPage, $selectedPage]
            );
        } catch (\Exception $e) {
            $result = new ShowedPages($firstPage, $lastPage, $selectedPage);
        }

        return $result;
    }

    /**
     * @return ShowedPagesInterface
     */
    public function getShowedPages()
    {
        return $this->showedPages;
    }

    /**
     * @param ShowedPagesInterface $showedPages
     * @return static
     */
    protected function setShowedPages(ShowedPagesInterface $showedPages)
    {
        $this->showedPages = $showedPages;

        return $this;
    }

    /**
     * @return static
     */
    abstract protected function buildShowedPages();
}
