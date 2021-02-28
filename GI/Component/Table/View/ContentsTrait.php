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

use GI\Component\Table\ViewModel\OrderInterface;
use GI\DOM\HTML\Element\Table\TableInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\Pattern\ArrayExchange\ExtractionInterface;

trait ContentsTrait
{
    /**
     * @var OrderInterface
     */
    private $viewModel;

    /**
     * @var array|ExtractionInterface
     */
    private $dataSource;

    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var THInterface[]
     */
    private $headerCells = [];

    /**
     * @var HiddenInterface
     */
    private $orderHidden;

    /**
     * @var HiddenInterface
     */
    private $directionHidden;

    /**
     * @var FormInterface
     */
    private $orderForm;


    /**
     * @return OrderInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param OrderInterface $viewModel
     * @return static
     */
    public function setViewModel(OrderInterface $viewModel)
    {
        $this->viewModel = $viewModel;

        return $this;
    }

    /**
     * @return array|ExtractionInterface
     */
    protected function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @param array|ExtractionInterface $dataSource
     * @return static
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateViewModel()
    {
        if (!($this->getViewModel() instanceof OrderInterface)) {
            $this->giThrowInvalidTypeException('View', '', 'ViewModelInterface');
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateDataSource()
    {
        $isArray                = is_array($this->getDataSource());
        $isExtractionInterface  = ($this->getDataSource() instanceof ExtractionInterface);

        if (!$isArray && !$isExtractionInterface) {
            $this->giThrowInvalidTypeException('DataSource', '', 'ExtractionInterface');
        }
    }

    /**
     * @return TableInterface
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasHeaderCell(string $id)
    {
        return isset($this->headerCells[$id]);
    }

    /**
     * @param string $id
     * @return THInterface
     * @throws \Exception
     */
    public function getHeaderCell(string $id)
    {
        if (!$this->hasHeaderCell($id)) {
            $this->giThrowNotInScopeException($id);
        }

        return $this->headerCells[$id];
    }

    /**
     * @return HiddenInterface
     */
    public function getOrderHidden()
    {
        return $this->orderHidden;
    }

    /**
     * @return HiddenInterface
     */
    public function getDirectionHidden()
    {
        return $this->directionHidden;
    }

    /**
     * @return FormInterface
     */
    public function getOrderForm()
    {
        return $this->orderForm;
    }
}