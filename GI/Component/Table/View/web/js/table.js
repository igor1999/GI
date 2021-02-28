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
giClient.component.table.Table = function()
{
    giClient.core.widget.Base.call(this);


    let me = this;


    let _orderHidden;
    this.getOrderHidden = function()
    {
        return _orderHidden;
    };

    let _directionHidden;
    this.getDirectionHidden = function()
    {
        return _directionHidden;
    };

    let _orderLinks;
    this.getOrderLinks = function()
    {
        return _orderLinks;
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _orderHidden     = this.getObjectElement('order-hidden');
        _directionHidden = this.getObjectElement('direction-hidden');
        _orderLinks      = this.getObjectElementList('order-link');

        initOrderLinks();

        return this;
    };

    let initOrderLinks = function()
    {
        for (let i = 0; i <= _orderLinks.length - 1; i ++) {
            initOrderLink(_orderLinks[i]);
        }
    };

    let initOrderLink = function(link)
    {
        if (_orderHidden) {
            link.addEventListener(
                'click',
                function()
                {
                    _orderHidden.value     = link.getAttribute('data-order-criteria');
                    _directionHidden.value = link.getAttribute('data-order-direction');

                    try {
                        me.findRelationTarget('paging').reset();
                    } catch (e) {}

                    me.submitControlRelatedForm(_orderHidden);
                }
            );
        }
    };
};