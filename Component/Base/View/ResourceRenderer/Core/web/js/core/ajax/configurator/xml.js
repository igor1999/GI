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
giClient.core.ajax.configurator.XML = function()
{
    giClient.core.ajax.configurator.AbstractConfigurator.call(this);


    this.construct = function()
    {
        this.reset().getSender().setRequestTypeToXML();

        return this;
    };

    this.reset = function()
    {
        this.getSender().reset().setMethodToPost();

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

        this.getSender().setCSRFHeader(true).send(url, body, successCallback, failCallback);

        return this;
    };

    let createBody = function(query)
    {
        let result = '';

        if (typeof(query) === 'string') {
            result = query
        } else {
            throw new Error('Query type for AJAX XML request should be a string only');
        }

        return result;
    };
};