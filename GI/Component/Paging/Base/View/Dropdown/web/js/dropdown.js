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
giClient.component.paging.dropdown.Dropdown = function()
{
    giClient.component.paging.base.Paging.call(this);


    let me = this;


    let _pagesSelect;
    this.getPagesSelect = function()
    {
        return _pagesSelect;
    };


    let _parentConstruct = this.construct;
    this.construct = function(objectHash)
    {
        _parentConstruct.call(this, objectHash);

        _pagesSelect = this.getObjectElement('pages-select');

        initPagesSelect();

        return this;
    };

    let initPagesSelect = function()
    {
        if (_pagesSelect && me.getSelectedPageHidden()) {
            _pagesSelect.addEventListener(
                'change',
                function()
                {
                    me.getSelectedPageHidden().value = _pagesSelect.value;

                    me.submitControlRelatedForm(me.getSelectedPageHidden());
                }
            );
        }
    };

    let parentReset = this.reset;
    this.reset = function()
    {
        parentReset.call(this);

        _pagesSelect.selectedIndex = 0;

        return this;
    };
};