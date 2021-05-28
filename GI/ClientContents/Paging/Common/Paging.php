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
namespace GI\ClientContents\Paging\Common;

use GI\ClientContents\Paging\Base\AbstractPaging;
use GI\ClientContents\Paging\Common\Context\Context;

use GI\ClientContents\Paging\Common\Context\ContextInterface;

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
            $this->context = $this->getGiServiceLocator()->getDependency(ContextInterface::class, Context::class);
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
            $this->createShowedPages(1, $this->getPagesTotal(), $this->getSelectedPage())
        );

        return $this;
    }
}
