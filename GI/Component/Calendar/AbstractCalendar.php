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
namespace GI\Component\Calendar;

use GI\Component\Base\AbstractComponent;
use GI\Component\Calendar\ViewModel\ViewModel;

use GI\Component\Calendar\ViewModel\ViewModelInterface;
use GI\Component\Calendar\View\WidgetInterface;

abstract class AbstractCalendar extends AbstractComponent implements CalendarInterface
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;


    /**
     * @return WidgetInterface
     */
    abstract protected function getView();

    /**
     * AbstractCalendar constructor.
     * @param ViewModelInterface|null $viewModel
     * @throws \Exception
     */
    public function __construct(ViewModelInterface $viewModel = null)
    {
        $this->viewModel = ($viewModel instanceof ViewModelInterface)
            ? $viewModel
            : $this->getGiServiceLocator()->getDependency(ViewModelInterface::class, ViewModel::class);
    }

    /**
     * @return ViewModelInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param array $data
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $data)
    {
        $this->getViewModel()->hydrate($data);
        $this->getViewModel()->filter();

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()->setViewModel($this->getViewModel())->toString();
    }
}