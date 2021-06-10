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
giClient.component.menu.Menu = function()
{
    giClient.core.widget.Base.call(this);


    let _nsDom = giClient.core.dom;

    let me = this;

    let _context;
    this.getContext = function()
    {
        return _context;
    };

    let _container;
    this.getContainer = function()
    {
        return _container;
    };

    let _selectedOptions = [];
    this.getSelectedOptions = function ()
    {
        return _selectedOptions;
    };

    let _options = {};
    this.getOptions = function ()
    {
        return _options;
    };
    this.getOption = function (optionId)
    {
        if (!(optionId in _options)) {
            throw new Error('Option id not found');
        }

        return _options[optionId];
    };

    let _eventAllocationMargins = {x: -15, y: 10};
    this.getEventAllocationMargins = function()
    {
        return _eventAllocationMargins;
    };
    this.setEventAllocationMarginX = function(x)
    {
        if (typeof(x) !== 'number') {
            throw new Error('Allocation margin x should be a number');
        }

        _eventAllocationMargins.x = x;

        return this;
    };
    this.setEventAllocationMarginY = function(y)
    {
        if (typeof(y) !== 'number') {
            throw new Error('Allocation margin y should be a number');
        }

        _eventAllocationMargins.y = y;

        return this;
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _context = this.getServerData('is-context');

        _container = this.getObjectElement('top-menu');

        let options = _container.querySelectorAll('div[data-option-id]');
        for (let i = 0; i <= options.length - 1; i ++) {
            _options[i] = new giClient.component.menu.Option().construct(this, options[i]);
        }

        return this;
    };

    this.hide = function(level)
    {
        for (let i = level; i <= _selectedOptions.length - 1; i++) {
            _selectedOptions[i].selectOption(false);
            _selectedOptions[i].showSubmenu(false);
        }

        this.spliceSelectedOptions(level);

        return this;
    };

    this.addSelectedOption = function(option)
    {
        _selectedOptions[option.getLevel()] = option;

        return this;
    };

    this.spliceSelectedOptions = function(level)
    {
        _selectedOptions.splice(level);

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.beforeSelect = function(option)
    {
        try {
            // noinspection JSUnresolvedFunction
            this.findRelationTarget('before-select').beforeSelectMenu(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.afterSelect = function(option)
    {
        try {
            // noinspection JSUnresolvedFunction
            this.findRelationTarget('after-select').afterSelectMenu(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.beforeUnselect = function(option)
    {
        try {
            // noinspection JSUnresolvedFunction
            this.findRelationTarget('before-unselect').beforeUnselectMenu(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.afterUnselect = function(option)
    {
        try {
            // noinspection JSUnresolvedFunction
            this.findRelationTarget('after-unselect').afterUnselectMenu(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.beforeClick = function(option)
    {
        try {
            // noinspection JSUnresolvedFunction
            this.findRelationTarget('before-click').beforeMenuClick(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.afterClick = function(option)
    {
        try {
            // noinspection JSUnresolvedFunction
            this.findRelationTarget('after-click').afterMenuClick(option);
        } catch (e) {}

        return this;
    };

    this.showAsContextMenu = function(e)
    {
        if (!_context) {
            throw new Error('This menu is not context');
        }

        if (!(e instanceof Event)) {
            throw new Error('Argument is not an Event object');
        }

        _container.style.left = (e.location.pageX + _eventAllocationMargins.x) + 'px';
        _container.style.top  = (e.location.pageY + _eventAllocationMargins.y) + 'px';

        _nsDom.show(_container);

        let documentClick = function ()
        {
            me.hideAsContextMenu();
            document.removeEventListener('click', documentClick);
        };

        document.addEventListener('click', documentClick);

        return this;
    }

    this.hideAsContextMenu = function()
    {
        if (!_context) {
            throw new Error('This menu is not context');
        }

        _nsDom.hide(_container);

        return this;
    }
};