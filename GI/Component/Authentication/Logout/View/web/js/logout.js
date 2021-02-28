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
giClient.component.authentication.logout.Logout = function()
{
    giClient.core.widget.Base.call(this);


    let me = this;


    let _link;
    this.getLink = function()
    {
        return _link;
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _link = this.getObjectElement('link');

        _link.addEventListener(
            'click',
            function()
            {
                let url = _link.getAttribute('data-check-action');

                me.createAjax().getUrlEncoded().setMethodToPost().send(
                    url, {}, function(href) {document.location.href = href;}
                );
            }
        );

        return this;
    };
};