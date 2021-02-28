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
namespace GI\Component\Authentication\Login\View;

use GI\Component\Base\View\AbstractView as Base;
use GI\Component\Authentication\Login\View\Widget\Widget;

use GI\Component\Authentication\Login\View\Widget\WidgetInterface;
use GI\Component\Authentication\Login\Dialog\DialogInterface;

/**
 * Class View
 * @package GI\Component\Authentication\Login\View
 *
 * @method DialogInterface getDialog()
 * @method ViewInterface setDialog(DialogInterface $dialog)
 */
class View extends Base implements ViewInterface
{
    /**
     * @var WidgetInterface
     */
    private $widget;


    /**
     * View constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->widget = $this->giGetDi(WidgetInterface::class, Widget::class);
    }

    /**
     * @return WidgetInterface
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateDialog()
    {
        if (!($this->getDialog() instanceof DialogInterface)) {
            $this->giThrowInvalidTypeException('Dialog', '', 'DialogInterface');
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->validateProperties()->getWidget()->addDialogRelation($this->getDialog());

        return parent::toString();
    }
}