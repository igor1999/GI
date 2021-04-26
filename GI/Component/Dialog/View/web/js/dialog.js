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
giClient.component.dialog.Dialog = function()
{
    giClient.core.widget.Base.call(this);

    let me = this;


    let _container;
    this.getContainer = function()
    {
        return _container;
    };

    let _cover;
    this.getCover = function()
    {
        return _cover;
    };

    let _frame;
    this.getFrame = function()
    {
        return _frame;
    };

    let _header;
    this.getHeader = function()
    {
        return _header;
    };

    let _title;
    this.getTitle = function()
    {
        return _title;
    };

    let _closeButton;
    this.getCloseButton = function()
    {
        return _closeButton;
    };

    let _content;
    this.getContent = function()
    {
        return _content;
    };

    let _footer;
    this.getFooter = function()
    {
        return _footer;
    };

    let _footerDescription;
    this.getFooterDescription = function()
    {
        return _footerDescription;
    };

    let _resize;
    this.getResize = function()
    {
        return _resize;
    };

    let _modality;
    this.getModality = function()
    {
        return _modality;
    };
    this.setModality = function(modality)
    {
        _modality = modality;

        let classModal = 'gi-css-cover-modal';

        if (_modality) {
            _cover.classList.add(classModal);
        } else {
            _cover.classList.remove(classModal);
        }

        return this;
    };

    let _eventAllocationMargins = {x: -15, y: 10};
    this.getEventAllocationMargins = function()
    {
        return _eventAllocationMargins;
    };
    this.setEventAllocationMarginX = function(x)
    {
        if (typeof(x) !== 'number') {
            throw new Error('Allocation margin x should be a number');
        }

        _eventAllocationMargins.x = x;

        return this;
    };
    this.setEventAllocationMarginY = function(y)
    {
        if (typeof(y) !== 'number') {
            throw new Error('Allocation margin y should be a number');
        }

        _eventAllocationMargins.y = y;

        return this;
    };

    let _movingOn = false;
    let _movingStartPoint = {x: null, y: null};

    let _resizingOn = false;
    let _resizingStartPoint = {x: null, y: null, width: null, height: null};


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _container         = this.getObjectElement('container');
        _cover             = this.getObjectElement('cover', _container);
        _frame             = this.getObjectElement('frame', _container);
        _header            = this.getObjectElement('header', _container);
        _title             = this.getObjectElement('title', _container);
        _closeButton       = this.getObjectElement('close-button', _container);
        _content           = this.getObjectElement('content', _container);
        _footer            = this.getObjectElement('footer', _container);
        _footerDescription = this.getObjectElement('footer-description', _container);
        _resize            = this.getObjectElement('resize', _container);
        _modality          = this.getServerData('modality') === '1';

        initDragDrop();
        initResize();

        initHide();

        return this;
    };

    let initDragDrop = function()
    {
        _title.addEventListener(
            'mousedown',
            function(eOnDown)
            {
                _movingOn = true;
                _movingStartPoint.x = eOnDown.pageX - _frame.offsetLeft;
                _movingStartPoint.y = eOnDown.pageY - _frame.offsetTop;

                document.onmousemove = function(eOnMove)
                {
                    if (_movingOn)
                    {
                        me.allocate(eOnMove.pageX - _movingStartPoint.x, eOnMove.pageY - _movingStartPoint.y);
                    }
                };

                document.onmouseup = function()
                {
                    _movingOn = false;

                    document.onmousemove = null;
                    document.onmouseup = null;
                };
            }
        );
    };

    let initResize = function()
    {
        _resize.addEventListener(
            'mousedown',
            function(eOnDown)
            {
                _resizingOn = true;
                _resizingStartPoint.x = eOnDown.pageX;
                _resizingStartPoint.y = eOnDown.pageY;
                _resizingStartPoint.width = me.getFrame().offsetWidth;
                _resizingStartPoint.height = me.getContainer().offsetHeight;

                document.onmousemove = function(eOnMove)
                {
                    if (_resizingOn)
                    {
                        let frame = me.getFrame();
                        frame.style.width = (eOnMove.pageX - _resizingStartPoint.x + _resizingStartPoint.width) + 'px';

                        let container = me.getContainer();
                        container.style.height = (eOnMove.pageY - _resizingStartPoint.y + _resizingStartPoint.height)
                            + 'px';
                    }
                };

                document.onmouseup = function()
                {
                    _resizingOn = false;

                    document.onmousemove = null;
                    document.onmouseup = null;
                };
            }
        );
    };

    let initHide = function()
    {
        _closeButton.addEventListener(
            'click',
            function()
            {
                _cover.style.display = 'none';
                _frame.style.display = 'none';
            }
        );
    };


    this.show = function(location)
    {
        let x, y;

        switch (true) {
            case location instanceof Event:
                x = location.pageX + _eventAllocationMargins.x;
                y = location.pageY + _eventAllocationMargins.y;
                this.allocate(x, y);
                break;
            case typeof(location) === 'object':
                ({x = null, y = null} = location);
                this.allocate(x, y);
                break;
            case location === true:
                this.center();
                break;
        }

        _cover.style.display = 'block';
        _frame.style.display = 'block';

        return this;
    };


    this.allocate = function(x, y)
    {
       this.allocateX(x).allocateY(y);

        return this;
    };

    this.allocateX = function(x)
    {
        if (typeof(x) !== 'number') {
            throw new Error('Allocation coordinate x should be a number');
        }

        _frame.style.left = x + 'px';

        return this;
    };

    this.allocateY = function(y)
    {
        if (typeof(y) !== 'number') {
            throw new Error('Allocation coordinate y should be a number');
        }

        _frame.style.top = y + 'px';

        return this;
    };

    this.center = function()
    {
        let x = (window.innerWidth - _frame.offsetWidth) / 2;
        let y = (window.innerHeight - _frame.offsetHeight) / 2;

        this.allocate(x, y);

        return this;
    };


    this.hide = function()
    {
        _closeButton.click();

        return this;
    };
};