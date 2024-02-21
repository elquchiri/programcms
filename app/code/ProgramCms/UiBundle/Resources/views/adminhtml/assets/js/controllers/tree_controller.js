/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from '@hotwired/stimulus';

application.register('tree', class extends Controller {
    /**
     * Controller Values
     * @type {{open: {default: boolean, type: BooleanConstructor}}}
     */
    static values = {
        open: {type: Boolean, default: false}
    };

    connect() {
        let treeChild = $('.tree ul.child');
        if (this.openValue) {
            treeChild.show();
            treeChild.find('span.title').addClass('closed');
        }

        $('.tree ul li span.title').click(function (e) {
            e.preventDefault();

            let childElement = $(this).next();
            if (childElement.length) {
                childElement.toggle();

                if ($(this).hasClass('closed')) {
                    $(this).removeClass('closed');
                } else {
                    $(this).addClass('closed');
                }
            }
        });

        $('.tree ul li span.title .category-name').click(function (e) {
            e.stopPropagation();
            window.location.href = $(this).data('url');
        });

        $('.tree-group').click(function (e) {
            e.preventDefault();

            let id = $(this).attr('id');
            switch (id) {
                case 'collapse':
                    treeChild.hide();
                    treeChild.find('span.title').removeClass('closed');
                    break;
                case 'expand':
                    treeChild.show();
                    treeChild.find('span.title').addClass('closed');
                    break;
            }
        });
    }
});