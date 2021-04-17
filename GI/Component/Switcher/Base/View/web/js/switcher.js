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

        _allowOff = (this.getServerData('is-allow-off') === 1);

        let selectionHolder = this.getObjectElement('selection-holder');

        let elements = this.getObjectElement('container').querySelectorAll('[data-value]');
        for (let i = 0; i <= elements.length - 1; i++) {
            let option = new giClient.component.switcher.Option().construct(this, elements[i], selectionHolder);

            _options[option.getValue()] = option;
        }

        return this;
    };

    this.unselectAll = function()
    {
        for (let value in _options) {
            _options[value].unselect();
        }

        return this;
    };

    // noinspection JSUnusedLocalSymbols
    this.onSelect = function(option)
    {
        return this;
    }

    // noinspection JSUnusedLocalSymbols
    this.onUnselect = function(option)
    {
        return this;
    }
}