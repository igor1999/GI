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
giClient.core.widget.Factory = function()
{
    let _items = {};
    this.getItems = function()
    {
        return _items;
    };
    this.has = function(objectHash)
    {
        return (objectHash in _items);
    };
    this.get = function(objectHash)
    {
        if (!this.has(objectHash)) {
            throw new Error(`Object hash \'${objectHash}\' not found in factory`);
        }

        return _items[objectHash];
    };

    let _initialized = false;
    this.getInitialized = function()
    {
        return _initialized;
    };

    this.setLoading = function(giJSClass)
    {
        let me = this;

        window.addEventListener(
            'load',
            function()
            {
                me.init(giJSClass);
            }
        );
    };

    this.init = function(giJSClass)
    {
        if (!_initialized) {
            _initialized = true;

            let contents = giClient.core.widget.selector.getAllByJSClass(document, giJSClass);

            for (let i = 0; i <= contents.length - 1; i++) {
                let objectHash = contents[i].getAttribute('data-gi-js-object');

                if (this.has(objectHash)) {
                    throw new Error(`Object with hash \'${objectHash}\' in class \'${giJSClass}\' already exists`);
                }

                _items[objectHash] = this.create(objectHash);

                giClient.core.widget.repository.set(objectHash, _items[objectHash]);
            }
        } else {
            throw new Error(`Class \'${giJSClass}\' already initialized`);
        }

        return this;
    };

    this.create = function(objectHash)
    {
        return objectHash;
    };
};