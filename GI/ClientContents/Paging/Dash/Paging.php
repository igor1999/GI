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
namespace GI\ClientContents\Paging\Dash;

use GI\ClientContents\Paging\Base\AbstractPaging;
use GI\ClientContents\Paging\Dash\Context\Context;

use GI\ClientContents\Paging\Base\ShowedPages\ShowedPagesInterface;
use GI\ClientContents\Paging\Dash\Context\ContextInterface;

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
        $point1 = $this->getContext()->getFrontPart();
        $point2 = $this->getSelectedPage() - $this->getContext()->getReach();
        $point3 = $this->getSelectedPage() + $this->getContext()->getReach();
        $point4 = $this->getPagesTotal() - $this->getContext()->getBackPart() + 1;

        switch (true) {
            case ($point1 >= $point4) || ($point1 >= $point2 && $point3 >= $point4):
                $showedPages = $this->getShowedPagesForSingleLine();
                break;
            case $point1 >= $point2:
                $showedPages = $this->getShowedPagesForTwoLinesFront($point3, $point4);
                break;
            case $point3 >= $point4:
                $showedPages = $this->getShowedPagesForTwoLinesBack($point1, $point2);
                break;
            default:
                $showedPages = $this->getShowedPagesForThreeLines($point1, $point2, $point3, $point4);
                break;
        }

        $this->setShowedPages($showedPages);

        return $this;
    }

    /**
     * @return ShowedPagesInterface
     * @throws \Exception
     */
    protected function getShowedPagesForSingleLine()
    {
        return $this->createShowedPages(1, $this->getPagesTotal(), $this->getSelectedPage());
    }

    /**
     * @param int $point3
     * @param int $point4
     * @return ShowedPagesInterface
     * @throws \Exception
     */
    protected function getShowedPagesForTwoLinesFront(int $point3, int $point4)
    {
        $line1 = $this->createShowedPages(1, $point3, $this->getSelectedPage());
        $line2 = $this->createShowedPages($point4, $this->getPagesTotal(), $this->getSelectedPage());

        return $line1->setNext($line2);
    }

    /**
     * @param int $point1
     * @param int $point2
     * @return ShowedPagesInterface
     * @throws \Exception
     */
    protected function getShowedPagesForTwoLinesBack(int $point1, int $point2)
    {
        $line1 = $this->createShowedPages(1, $point1, $this->getSelectedPage());
        $line2 = $this->createShowedPages($point2, $this->getPagesTotal(), $this->getSelectedPage());

        return $line1->setNext($line2);
    }

    /**
     * @param int $point1
     * @param int $point2
     * @param int $point3
     * @param int $point4
     * @return ShowedPagesInterface
     * @throws \Exception
     */
    protected function getShowedPagesForThreeLines(int $point1, int $point2, int $point3, int $point4)
    {
        $line1 = $this->createShowedPages(1, $point1, $this->getSelectedPage());
        $line2 = $this->createShowedPages($point2, $point3, $this->getSelectedPage());
        $line3 = $this->createShowedPages($point4, $this->getPagesTotal(), $this->getSelectedPage());

        $line1->setNext($line2);
        $line2->setNext($line3);

        return $line1;
    }
}
