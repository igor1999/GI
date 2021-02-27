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
giClient.component.paging.base.Paging = function()
{
    giClient.core.widget.Base.call(this);


    let me = this;


    let _sizesSelect;
    this.getSizesSelect = function()
    {
        return _sizesSelect;
    };

    let _selectedPageHidden;
    this.getSelectedPageHidden = function()
    {
        return _selectedPageHidden;
    };

    let _naviToFirst;
    this.getNaviToFirst = function()
    {
        return _naviToFirst;
    };

    let _naviToPrev;
    this.getNaviToPrev = function()
    {
        return _naviToPrev;
    };

    let _naviToNext;
    this.getNaviToNext = function()
    {
        return _naviToNext;
    };

    let _naviToLast;
    this.getNaviToLast = function()
    {
        return _naviToLast;
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        try {
            _sizesSelect    = this.getObjectElement('sizes-select');
        } catch (e) {}
        _selectedPageHidden = this.getObjectElement('selected-page-hidden');
        _naviToFirst        = this.getObjectElement('navi-to-first');
        _naviToPrev         = this.getObjectElement('navi-to-prev');
        _naviToNext         = this.getObjectElement('navi-to-next');
        _naviToLast         = this.getObjectElement('navi-to-last');

        initSizesSelect();

        initNavi(_naviToFirst);
        initNavi(_naviToPrev);
        initNavi(_naviToNext);
        initNavi(_naviToLast);

        return this;
    };

    let initSizesSelect = function()
    {
        if (_sizesSelect) {
            _sizesSelect.addEventListener(
                'change',
                function()
                {
                    me.submitControlRelatedForm(_sizesSelect);
                }
            );
        }
    };

    let initNavi = function(button)
    {
        if (button && _selectedPageHidden && (button.getAttribute('data-active') === '1')) {
            button.querySelector('a').addEventListener(
                'click',
                function()
                {
                    _selectedPageHidden.value = button.getAttribute('data-target-page');

                    me.submitControlRelatedForm(_selectedPageHidden);
                }
            );
        }
    };

    this.reset = function()
    {
        _selectedPageHidden.value = 1;

        return this;
    };
};