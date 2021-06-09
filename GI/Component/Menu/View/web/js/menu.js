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


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

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
            this.findRelationTarget('before-select').beforeSelect(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.afterSelect = function(option)
    {
        try {
            this.findRelationTarget('after-select').afterSelect(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.beforeUnselect = function(option)
    {
        try {
            this.findRelationTarget('before-unselect').beforeUnselect(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.afterUnselect = function(option)
    {
        try {
            this.findRelationTarget('after-unselect').afterUnselect(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.beforeClick = function(option)
    {
        try {
            this.findRelationTarget('before-click').beforeClick(option);
        } catch (e) {}

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.afterClick = function(option)
    {
        try {
            this.findRelationTarget('after-click').afterClick(option);
        } catch (e) {}

        return this;
    };
};