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
giClient.core.ajax.configurator.UrlEncoded = function()
{
    giClient.core.ajax.configurator.AbstractConfigurator.call(this);


    this.construct = function()
    {
        this.reset().getSender().setRequestTypeToUrlEncoded();

        return this;
    };

    this.reset = function()
    {
        this.getSender().reset().setMethodToGet();

        return this;
    };

    this.setMethodToGet = function()
    {
        this.getSender().setMethodToGet();

        return this;
    };

    this.setMethodToPost = function()
    {
        this.getSender().setMethodToPost();

        return this;
    };

    this.setMethodToPut = function()
    {
        this.getSender().setMethodToPut();

        return this;
    };

    this.setMethodToDelete = function()
    {
        this.getSender().setMethodToDelete();

        return this;
    };

    this.send = function(url, query, successCallback, failCallback)
    {
        let body = createBody(query);

        if (this.getSender().isMethodGet()) {
            url += '?' + body;
            body = '';
            this.getSender().setCSRFHeader(false);
        } else {
            let csrf = (typeof(query) === 'string') || !('gi-csrf-token' in query);

            this.getSender().setCSRFHeader(csrf);
        }

        this.getSender().send(url, body, successCallback, failCallback);

        return this;
    };

    let createBody = function(query)
    {
        let result = '';

        if (typeof(query) === 'string') {
            result = query
        } else if (query instanceof Object) {
            result = createUrlEncodedBody(query);
        } else {
            throw new Error('Query type for url encoded request should be a string or specific Object');
        }

        return result;
    };

    let createUrlEncodedBody = function(query)
    {
        let queryString = [];

        for (let key in query) {
            if (query[key] instanceof Array) {
                queryString.push(encodeArray(key, query[key]));
            } else if (typeof(query[key]) !== 'object') {
                queryString.push(key + '=' + encodeURIComponent(query[key]));
            } else {
                throw new Error('Format of url encoded AJAX request failed');
            }
        }

        return queryString.join('&');
    };

    let encodeArray = function(name, values)
    {
        let query = [];

        for (let i = 0; i <= values.length - 1; i ++) {
            if (typeof(values[i]) !== 'object') {
                query.push(name + '=' + encodeURIComponent(values[i]));
            } else {
                throw new Error('Format of url encoded AJAX request failed');
            }
        }

        return query.join('&');
    }
};