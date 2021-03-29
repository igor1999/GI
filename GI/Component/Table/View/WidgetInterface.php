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
namespace GI\Component\Table\View;

use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;
use GI\Component\Paging\Base\PagingInterface;
use GI\Component\Table\ViewModel\OrderInterface as ViewModelInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\DOM\HTML\Element\Table\TableInterface;
use GI\Pattern\ArrayExchange\ExtractionInterface;

interface WidgetInterface extends BaseInterface
{
    /**
     * @param ViewModelInterface $viewModel
     * @return static
     */
    public function setViewModel(ViewModelInterface $viewModel);

    /**
     * @param array|ExtractionInterface $dataSource
     * @return static
     */
    public function setDataSource($dataSource);

    /**
     * @return TableInterface
     */
    public function getTable();

    /**
     * @param PagingInterface $paging
     * @return static
     * @throws \Exception
     */
    public function setPagingRelation(PagingInterface $paging);

    /**
     * @param string $id
     * @return bool
     */
    public function hasHeaderCell(string $id);

    /**
     * @param string $id
     * @return THInterface
     * @throws \Exception
     */
    public function getHeaderCell(string $id);

    /**
     * @return HiddenInterface
     */
    public function getOrderHidden();

    /**
     * @return HiddenInterface
     */
    public function getDirectionHidden();

    /**
     * @return FormInterface
     */
    public function getOrderForm();
}