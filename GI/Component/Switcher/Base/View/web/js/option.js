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
giClient.component.switcher.Option = function()
{
    let me = this;


    let _owner;
    this.getOwner = function()
    {
        return _owner;
    };

    let _element;
    this.getElement = function()
    {
        return _element;
    };

    let _selectionHolder;


    this.construct = function(owner, element, selectionHolder)
    {
        _owner   = owner;
        _element = element;

        _selectionHolder = selectionHolder;

        _element.addEventListener(
            'click',
            function()
            {
                me.select();
            }
        );

        return this;
    };

    this.select = function()
    {
        let selected = !this.isSelected() || !_owner.isAllowOff();

        _owner.unselectAll();

        if (selected) {
            select(true);
            _selectionHolder.value = this.getValue();
        }

        _owner.onSelect(this);

        return this;
    };

    this.unselect = function()
    {
        if (this.isSelected()) {
            select(false);
            _selectionHolder.value = '';
        }

        _owner.onUnselect(this);

        return this;
    };

    let select = function(selected)
    {
        _element.setAttribute('data-selected',  selected ? 1 : 0);
    };

    this.getValue = function()
    {
        return _element.getAttribute('data-value');
    };

    this.isSelected = function()
    {
        return _element.getAttribute('data-selected') === '1';
    };
}