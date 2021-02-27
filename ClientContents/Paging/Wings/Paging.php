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
namespace GI\ClientContents\Paging\Wings;

use GI\ClientContents\Paging\Base\AbstractPaging;
use GI\ClientContents\Paging\Wings\Context\Context;

use GI\ClientContents\Paging\Wings\Context\ContextInterface;

class Paging extends AbstractPaging implements PagingInterface
{
    /**
     * @var ContextInterface
     */
    private $context;


    /**
     * @return ContextInterface
     * @throws \Exception
     */
    public function getContext()
    {
        if (!$this->context instanceof ContextInterface) {
            $this->context = $this->giGetDi(ContextInterface::class, Context::class);
        }

        return $this->context;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function buildShowedPages()
    {
        $this->setShowedPages(
            $this->createShowedPages(
                $this->getFirstShowedPage(), $this->getLastShowedPage(), $this->getSelectedPage()
            )
        );

        return $this;
    }

    /**
     * @return int
     * @throws \Exception
     */
    protected function getFirstShowedPage()
    {
        $reach = $this->getContext()->getReach();

        switch (true) {
            case ($reach * 2 + 1) >= $this->getPagesTotal():
            case $this->getSelectedPage() <= ($reach + 1):
                $firstPage = 1;
                break;
            case $this->getSelectedPage() >= ($this->getPagesTotal() - $reach):
                $firstPage = $this->getPagesTotal() - $reach * 2 + 1;
                break;
            default:
                $firstPage = $this->getSelectedPage() - $reach;
                break;
        }

        return $firstPage;
    }

    /**
     * @return int
     * @throws \Exception
     */
    protected function getLastShowedPage()
    {
        $reach = $this->getContext()->getReach();

        switch (true) {
            case ($reach * 2 + 1) >= $this->getPagesTotal():
            case $this->getSelectedPage() >= ($this->getPagesTotal() - $reach):
                $lastPage = $this->getPagesTotal();
                break;
            case $this->getSelectedPage() <= ($reach + 1):
                $lastPage = $reach * 2 + 1;
                break;
            default:
                $lastPage = $this->getSelectedPage() + $reach;
                break;
        }

        return $lastPage;
    }
}
