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
giClient.component.menu.Option = function()
{
    let _nsDom = giClient.core.dom;

    let me = this;


    let _menu;
    this.getMenu = function()
    {
        return _menu;
    };

    let _element;
    this.getElement = function()
    {
        return _element;
    };

    let _level;
    this.getLevel = function()
    {
        return _level;
    };

    let _submenu;
    this.getSubmenu = function()
    {
        return _submenu;
    };


    this.construct = function (menu, element)
    {
        _menu    = menu;
        _element = element;
        _level   = _element.getAttribute('data-option-level');
        _submenu = _menu.getContainer().querySelector(`ul[data-submenu="${this.getId()}"]`);

        initSelect();
        initUnselect();
        initClick();

        return this;
    };

    let initSelect = function ()
    {
        _element.addEventListener(
            'mouseover',
            function ()
            {
                _menu.beforeSelect(me);

                let selectedOptions = _menu.getSelectedOptions();
                let selectedOption = _level <= selectedOptions.length - 1 ? selectedOptions[_level] : null;

                if ((selectedOption === null || me.getId() !== selectedOption.getId()) && !me.isDisabled()) {
                    if (selectedOption) {
                        _menu.hide(_level);
                    }

                    _menu.addSelectedOption(me);
                    me.selectOption(true);

                    let documentClick = function ()
                    {
                        _menu.hide(0);
                        document.removeEventListener('click', documentClick);
                    };

                    me.showSubmenu(true);

                    if (_submenu) {
                        document.addEventListener('click', documentClick);
                    } else {
                        document.removeEventListener('click', documentClick);
                    }
                }

                _menu.afterSelect(me);
            }
        );
    };

    let initUnselect = function()
    {
        _element.addEventListener(
            'mouseout',
            function()
            {
                _menu.beforeUnselect(me);

                if (!_submenu && !me.isDisabled()) {
                    me.selectOption(false);
                    _menu.spliceSelectedOptions(_level);
                }

                _menu.afterUnselect(me);
            }
        );
    };

    let initClick = function()
    {
        _element.addEventListener(
            'click',
            function()
            {
                _menu.beforeClick(me);
                _element.querySelector('a').click();
                _menu.afterClick(me);

                _menu.hide(0);
            }
        );
    };

    this.getId = function()
    {
        return _element.getAttribute('data-option-id');
    };

    this.getLocalId = function()
    {
        return _element.getAttribute('data-option-local-id');
    };

    this.getContainerId = function()
    {
        return _element.getAttribute('data-option-container-id');
    };

    this.isDisabled = function()
    {
        return _element.getAttribute('data-option-disabled') === '1';
    };


    this.setDisabled = function(value)
    {
        return _element.setAttribute('data-option-disabled', value);
    };

    this.selectOption = function(hover)
    {
        let hoverClass = 'gi-option-hover';

        if (hover) {
            _element.classList.add(hoverClass);
        } else {
            _element.classList.remove(hoverClass);
        }

        return this;
    };

    this.showSubmenu = function(show)
    {
        if (_submenu) {
            _nsDom.setVisibility(_submenu, show);
        }

        return this;
    };
};