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
giClient.core.ajax.Ajax = function()
{
    let _nsConfigurator = giClient.core.ajax.configurator;

    let _urlEncoded;
    this.getUrlEncoded = function()
    {
        if (!_urlEncoded) {
            _urlEncoded = new _nsConfigurator.UrlEncoded().construct();
        }

        return _urlEncoded;
    };

    let _json;
    this.getJson = function()
    {
        if (!_json) {
            _json = new _nsConfigurator.Json().construct();
        }

        return _json;
    };

    let _xml;
    this.getXml = function()
    {
        if (!_xml) {
            _xml = new _nsConfigurator.XML().construct();
        }

        return _xml;
    };

    let _multipart;
    this.getMultipart = function()
    {
        if (!_multipart) {
            _multipart = new _nsConfigurator.Multipart().construct();
        }

        return _multipart;
    };
};