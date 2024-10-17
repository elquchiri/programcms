/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from '@hotwired/stimulus';

application.register('tree-field', class extends Controller {
    /**
     * Controller Values
     * @type {{open: {default: boolean, type: BooleanConstructor}}}
     */
    static values = {
        open: {type: Boolean, default: false}
    };

    connect() {
        let treeChild = $('.tree-field ul.child');
        if (this.openValue) {
            treeChild.show();
            treeChild.find('span.title').addClass('closed');
        }

        $('.tree-field ul li span.title').click(function (e) {
            // e.preventDefault();

            let childElement = $(this).next();
            if (childElement.length) {
                // childElement.slideToggle('fast');
                childElement.toggle();

                if ($(this).hasClass('closed')) {
                    $(this).removeClass('closed');
                } else {
                    $(this).addClass('closed');
                }
            }
        });

        $('.tree-field ul li span.title .check-acl-input').on('change', function(e) {
            var childElement = $(this).parent().next();
            if (childElement.length) {
                childElement.show();
                if($(this).is(":checked")) {
                    childElement.find('input[type=checkbox]').prop('checked', true);
                }else{
                    childElement.find('input[type=checkbox]').prop('checked', false);
                }
            }
        });

        $('.tree-group').click(function (e) {
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