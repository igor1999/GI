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
namespace GI\Component\Autocomplete;

use GI\Component\Base\AbstractComponent;
use GI\Component\Autocomplete\View\Widget;
use GI\Component\Autocomplete\ViewModel\ViewModel;

use GI\Component\Autocomplete\View\WidgetInterface;
use GI\Component\Autocomplete\Context\ContextInterface;
use GI\Component\Autocomplete\ViewModel\ViewModelInterface;

abstract class AbstractAutocomplete extends AbstractComponent implements AutocompleteInterface
{
    /**
     * @var WidgetInterface
     */
    private $view;

    /**
     * @var array
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;


    /**
     * AbstractAutocomplete constructor.
     * @param array $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __construct(array $name = [], $value = '')
    {
        $this->name  = $name;
        $this->value = $value;

        $this->view = $this->giGetDi(WidgetInterface::class, Widget::class);

        $this->createContext();
    }

    /**
     * @return WidgetInterface
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return ContextInterface
     */
    abstract protected function getContext();

    /**
     * @return static
     */
    abstract protected function createContext();

    /**
     * @return array
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->getContext()->validateProperties();

        return $this->getView()
            ->setName($this->name)
            ->setValue($this->value)
            ->setContext($this->getContext())->toString();
    }

    /**
     * @param array $data
     * @return array[]
     * @throws \Exception
     */
    public function getList(array $data)
    {
        $viewModel = $this->createViewModel()->hydrate($data);

        if (!$viewModel->validate()) {
            $this->giThrowCommonException($viewModel->getValidator()->getFirstMessage());
        }

        return $this->createList($viewModel->getSearch());
    }

    /**
     * @param mixed $value
     * @return array[]
     */
    abstract protected function createList(string $value);

    /**
     * @return ViewModelInterface
     */
    protected function createViewModel()
    {
        try {
            $result = $this->giGetDi(ViewModelInterface::class);
        } catch (\Exception $e) {
            $result = new ViewModel();
        }

        return $result;
    }
}