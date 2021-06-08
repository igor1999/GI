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

/**
 * Class Widget
 * @package GI\Component\Menu\View
 *
 * @method ModelInterface getModel()
 * @method WidgetInterface setModel(ModelInterface $model)
 * @method bool isBar()
 * @method WidgetInterface setBar(bool $bar)
 */
class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS       = 'gi-menu';

    const CLIENT_CSS      = self::CLIENT_JS;

    const GI_ID_MENU      = 'menu';

    const GI_ID_OPTION    = 'option';


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
        $this->resourceRenderer = $this->getGiServiceLocator()->getDependency(
            ResourceRendererInterface::class, ResourceRenderer::class
        );

        $this->builderContainer = $this->getGiServiceLocator()->getDependency(
            BuilderContainerInterface::class, new BuilderContainer($this), [$this]
        );
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateModel()
    {
        if (!($this->getModel() instanceof ModelInterface)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Model', '', 'MenuInterface');
        }
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
     * @render
     * @gi-id top-menu
     * @return ULInterface
     * @throws \Exception
     */
    protected function getTopMenu()
    {
        if (!($this->topMenu instanceof ULInterface)) {
            $this->createMenu();
        }

        return $this->topMenu;
    }

    /**
     * @return DivInterface[][]
     * @throws \Exception
     */
    protected function getOptions()
    {
        if (!($this->topMenu instanceof ULInterface)) {
            $this->createMenu();
        }

        return $this->options;
    }

    /**
     * @param string $containerID
     * @param string $localID
     * @return DivInterface
     * @throws \Exception
     */
    protected function getOption(string $containerID, string $localID)
    {
        if (!($this->topMenu instanceof ULInterface)) {
            $this->createMenu();
        }

        if (!isset($this->options[$containerID][$localID])) {
            $this->getGiServiceLocator()->throwNotInScopeException($localID);
        }

        return $this->options[$containerID][$localID];
    }

    /**
     * @return ULInterface[]
     * @throws \Exception
     */
    protected function getPopups()
    {
        if (!($this->topMenu instanceof ULInterface)) {
            $this->createMenu();
        }

        return $this->popups;
    }

    /**
     * @param string $id
     * @return ULInterface
     * @throws \Exception
     */
    protected function getPopup(string $id)
    {
        if (!($this->topMenu instanceof ULInterface)) {
            $this->createMenu();
        }

        if (!array_key_exists($id, $this->popups)) {
            $this->getGiServiceLocator()->throwNotInScopeException($id);
        }

        return $this->popups[$id];
    }

    /**
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

        $clearItem = $this->getBuilderContainer()->getOptionBuilder()->buildClearItem();
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