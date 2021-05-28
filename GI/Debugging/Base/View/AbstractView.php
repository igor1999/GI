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
namespace GI\Debugging\Base\View;

use GI\Markup\Renderer\AbstractRenderer;

use GI\Debugging\Base\View\Context\ContextInterface;

abstract class AbstractView extends AbstractRenderer implements ViewInterface
{
    const PATH_TO_HTML = 'templates/html.phtml';

    const PATH_TO_TEXT = 'templates/text.phtml';


    /**
     * AbstractView constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->isHTML()) {
            $this->setTemplateByClass(static::class, static::PATH_TO_HTML);
        } else {
            $this->setTemplateByClass(static::class, static::PATH_TO_TEXT);
        }
    }

    /**
     * @return bool
     */
    protected function isHTML()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);
            $result  = $context->isHTML();
        } catch (\Exception $exception) {
            $result = !$this->getGiServiceLocator()->isCLI();
        }

        return $result;
    }
}