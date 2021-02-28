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
giClient.core.ajax.configurator.AbstractConfigurator = function()
{
    let _sender;
    this.getSender = function()
    {
        if (!_sender) {
            _sender = new giClient.core.ajax.Sender();
        }

        return _sender;
    };

    this.getMethod = function()
    {
        return this.getSender().getMethod();
    };

    this.getRequestType = function()
    {
        return this.getSender().getRequestType();
    };

    this.getCustomHeaders = function()
    {
        return this.getSender().getCustomHeaders();
    };

    this.setCustomHeaders = function(customHeaders)
    {
        this.getSender().setCustomHeaders(customHeaders);

        return this
    };

    this.getResponseType = function()
    {
        return this.getSender().getResponseType();
    };

    this.setResponseTypeToText = function()
    {
        this.getSender().setResponseTypeToText();

        return this;
    }

    this.setResponseTypeToJson = function()
    {
        this.getSender().setResponseTypeToJson();

        return this;
    }

    this.setResponseTypeToXML = function()
    {
        this.getSender().setResponseTypeToXML();

        return this;
    }

    this.setResponseTypeToHTML = function()
    {
        this.getSender().setResponseTypeToHTML();

        return this;
    }
};