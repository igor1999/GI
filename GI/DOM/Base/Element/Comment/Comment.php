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
namespace GI\DOM\Base\Element\Comment;

use GI\DOM\Base\Element\AbstractElement;

class Comment extends AbstractElement implements CommentInterface
{
    /**
     * @var string
     */
    private $text = '';


    /**
     * Comment constructor.
     * @param string $text
     */
    public function __construct(string $text = '')
    {
        parent::__construct('');

        $this->setText($text);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return static
     */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    protected function getTagTemplate()
    {
        return '<!-- %s%s -->';
    }

    /**
     * @return string
     */
    protected function getContents()
    {
        return $this->getText();
    }
}