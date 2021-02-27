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
namespace GI\Component\Menu\View;

use GI\Component\Base\View\Widget\AbstractWidget;
use GI\Component\Menu\View\Builder\Container\Container as BuilderContainer;

use GI\ClientContents\Menu\MenuInterface as ModelInterface;
use GI\Component\Menu\View\Builder\Container\ContainerInterface as BuilderContainerInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Lists\UL\ULInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS       = 'gi-menu';

    const CLIENT_CSS      = self::CLIENT_JS;

    const GI_ID_MENU      = 'menu';

    const GI_ID_OPTION    = 'option';


    /**
     * @var ModelInterface
     */
    private $model;

    /**
     * @var bool
     */
    private $bar = true;

    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var BuilderContainerInterface
     */
    private $builderContainer;

    /**
     * @var ULInterface
     */
    private $topMenu;

    /**
     * @var DivInterface[][]
     */
    private $options;

    /**
     * @var ULInterface[]
     */
    private $popups;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );

        $this->builderContainer = $this->giGetDi(
            BuilderContainerInterface::class, new BuilderContainer($this), [$this]
        );
    }

    /**
     * @return ModelInterface
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @param ModelInterface $model
     * @return static
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateModel()
    {
        if (!($this->model instanceof ModelInterface)) {
            $this->giThrowInvalidTypeException('Model', '', 'MenuInterface');
        }
    }

    /**
     * @return bool
     */
    public function isBar()
    {
        return $this->bar;
    }

    /**
     * @param bool $bar
     * @return static
     */
    public function setBar(bool $bar)
    {
        $this->bar = $bar;

        return $this;
    }

    /**
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return BuilderContainerInterface
     */
    protected function getBuilderContainer()
    {
        return $this->builderContainer;
    }

    /**
     * @return ULInterface
     */
    public function getTopMenu()
    {
        return $this->topMenu;
    }

    /**
     * @return DivInterface[][]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $containerID
     * @param string $localID
     * @return DivInterface
     * @throws \Exception
     */
    public function getOption(string $containerID, string $localID)
    {
        if (!isset($this->options[$containerID][$localID])) {
            $this->giThrowNotInScopeException($localID);
        }

        return $this->options[$containerID][$localID];
    }

    /**
     * @return ULInterface[]
     */
    public function getPopups()
    {
        return $this->popups;
    }

    /**
     * @param string $id
     * @return ULInterface
     * @throws \Exception
     */
    public function getPopup(string $id)
    {
        if (!array_key_exists($id, $this->popups)) {
            $this->giThrowNotInScopeException($id);
        }

        return $this->popups[$id];
    }

    /**
     * @render
     * @gi-id top-menu
     * @param ModelInterface|null $model
     * @param int $level
     * @return ULInterface
     * @throws \Exception
     */
    protected function createMenu(ModelInterface $model = null, int $level = 0)
    {
        if (!($model instanceof ModelInterface)) {
            $model = $this->getModel();
        }

        $id = $model->getID();

        if ($level == 0) {
            $this->topMenu = $menu = $this->getBuilderContainer()->getMenuBuilder()->buildMenu($id);
        } else {
            $this->popups[$id] = $menu = $this->getBuilderContainer()->getMenuBuilder()->buildPopupMenu($id);
            $this->addClientAttributes($menu,static::GI_ID_MENU);
        }

        $this->createOptions($model, $level, $menu);

        return $menu;
    }

    /**
     * @param ModelInterface $model
     * @param int $level
     * @param ULInterface $menu
     * @return static
     * @throws \Exception
     */
    protected function createOptions(ModelInterface $model, int $level, ULInterface $menu)
    {
        foreach ($model->getOptions() as $optionModel) {
            if (!$optionModel->isHidden()) {
                $optionContent = $this->getBuilderContainer()->getOptionContentBuilder()->buildOptionContent(
                    $optionModel, $level
                );
                $this->addClientAttributes($optionContent, static::GI_ID_OPTION);

                $this->options[$model->getID()][$optionModel->getLocalID()] = $optionContent;

                $popup = $optionModel->hasPopup() ? $this->createMenu($optionModel->getPopup(),$level + 1) : null;

                $options = $this->getBuilderContainer()->getOptionBuilder()->buildOption(
                    $level, $optionContent, $popup
                );

                if (is_array($options)) {
                    foreach ($options as $option) {
                        $menu->getChildNodes()->addItem($option);
                    }
                } else {
                    $menu->getChildNodes()->addItem($options);
                }
            }
        }

        $clearItem = $this->getBuilderContainer()->getoptionBuilder()->buildClearItem();
        $menu->getChildNodes()->addItem($clearItem);

        return $this;
    }

    /**
     * @return static
     */
    protected function build()
    {
        return $this;
    }
}