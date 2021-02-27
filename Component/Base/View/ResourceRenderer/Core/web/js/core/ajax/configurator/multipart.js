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
giClient.core.ajax.configurator.Multipart = function()
{
    giClient.core.ajax.configurator.AbstractConfigurator.call(this);


    this.construct = function()
    {
        this.reset().getSender().setRequestTypeToMultipart();

        return this;
    };

    this.reset = function()
    {
        this.getSender().reset().setMethodToPost();

        return this;
    };

    this.send = function(url, query, successCallback, failCallback)
    {
        let body = createBody(query);

        let csrf = !query.get('gi-csrf-token');

        this.getSender().setCSRFHeader(csrf).send(url, body, successCallback, failCallback);

        return this;
    };

    let createBody = function(query)
    {
        let result = '';

        if (query instanceof FormData) {
            result = query
        } else {
            throw new Error('Query type for multipart/form-data AJAX request should be a FormData object only');
        }

        return result;
    };
};