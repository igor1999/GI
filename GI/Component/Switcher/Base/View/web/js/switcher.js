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
giClient.component.switcher.Switcher = function()
{
    giClient.core.widget.Base.call(this);


    let me = this;


    let _selectionHolder = null;
    this.getSelectionHolder = function()
    {
        return _selectionHolder;
    };

    let _allowOff = false;
    this.isAllowOff = function()
    {
        return _allowOff;
    };

    let _options = {};
    this.getOptions = function()
    {
        return _options;
    };
    this.getOption = function(value)
    {
        if (!(value in _options)) {
            throw new Error('Option not found')
        }

        return _options[value];
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _selectionHolder = this.getObjectElement('selection-holder');
        _allowOff = (this.getServerData('is-allow-off') === 1);

        let options = this.getObjectElement('container').querySelectorAll('[data-value]');
        for (let i = 0; i <= options.length - 1; i++) {
            _options[getOptionValue(options[i])] = options[i];
            initOption(options[i]);
        }

        return this;
    };

    let initOption = function(option)
    {
        option.addEventListener(
            'click',
            function()
            {
                select(option);
            }
        );
    };

    let getOptionValue = function(option)
    {
        return option.getAttribute('data-value');
    };

    let isOptionSelected = function(option)
    {
        return option.getAttribute('data-selected') === 1;
    };

    let selectOption = function(option, selected)
    {
        option.setAttribute('data-selected',  selected ? 1 : 0);
    };

    let select = function(option)
    {
        let selected = (_selectionHolder.value !== getOptionValue(option)) || !_allowOff;

        unselectAll();
        selectOption(option, selected);
        _selectionHolder.value = selected ? getOptionValue(option) : '';
    }

    let unselectAll = function()
    {
        for (let value in _options) {
            selectOption(_options[value], false);
        }
    };

    this.select = function(value)
    {
        select(this.getOption(value));
    };

    this.unselectAll = function()
    {
        unselectAll();
    };
}