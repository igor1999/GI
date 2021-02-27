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
giClient.core.cookie.Collection = function()
{
    let _items = {};


    this.has = function(name)
    {
        return (name in _items);
    };

    this.get = function(name)
    {
        if (!this.has(name)) {
            throw new Error(`Name '${name}' not found in scope`);
        }

        return _items[name];
    };

    this.getItems = function()
    {
        return _items;
    };

    this.getLength = function()
    {
        return Object.keys(_items).length;
    };

    this.isEmpty = function()
    {
        return (this.getLength() === 0);
    };

    this.addInstance = function(cookie)
    {
        if (!(cookie instanceof giClient.core.cookie.Cookie)) {
            throw new Error('Cookie instance type failed');
        }

        _items[cookie.getName()] = cookie;

        return this;
    };

    this.addByName = function(name)
    {
        let cookie = new giClient.core.cookie.Cookie().construct(name);
        this.addInstance(cookie);

        return this;
    };

    this.setNames = function(names)
    {
        if (!(names instanceof Array)) {
            throw new Error('Cookie names should be an array');
        }

        this.clean();

        for (let i = 0; i <= names.length - 1; i ++) {
            let name = names[i];

            if (typeof(name) !== 'string') {
                throw new Error(`Name number ${i} is not a string`);
            }

            this.addByName(name);
        }

        return this;
    }

    this.find = function(regExp)
    {
        if (!(regExp instanceof RegExp)) {
            throw new Error('Search criteria should be a RegExp');
        }

        this.clean();

        let items = document.cookie.split(';');

        for (let i = 0; i <= items.length - 1; i ++) {
            let [name] = items[i].trim().split('=');

            if (name.match(regExp)) {
                this.addByName(name);
            }
        }

        return this;
    }

    this.remove = function(name)
    {
        let result = this.has(name);

        if (result) {
            delete _items[name];
        }

        return result;
    };

    this.clean = function()
    {
        _items = {};

        return this;
    };
};