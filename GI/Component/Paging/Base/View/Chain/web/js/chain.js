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
giClient.component.paging.chain.Chain = function()
{
    giClient.component.paging.base.Paging.call(this);


    let me = this;


    let _pageLinks;
    this.getPageLinks = function()
    {
        return _pageLinks;
    };


    let _parentConstruct = this.construct;
    this.construct = function(objectHash)
    {
        _parentConstruct.call(this, objectHash);

        let pagesContainer = this.getObjectElement('pages-container');

        _pageLinks = this.getObjectElementList('item', pagesContainer);

        initPageLinks();

        return this;
    };

    let initPageLinks = function()
    {
        for (let i = 0; i <= _pageLinks.length - 1; i ++) {
            let link = _pageLinks[i].querySelector('a[data-target-page]');

            if (link) {
                initPageLink(link);
            }
        }
    };

    let initPageLink = function(link)
    {
        if (me.getSelectedPageHidden()) {
            link.addEventListener(
                'click',
                function()
                {
                    let hidden = me.getSelectedPageHidden();

                    hidden.value = link.getAttribute('data-target-page');

                    me.submitControlRelatedForm(hidden);
                }
            );
        }
    };
};