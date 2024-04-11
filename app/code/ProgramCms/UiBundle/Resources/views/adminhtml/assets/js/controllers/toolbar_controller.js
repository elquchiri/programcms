/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import Modal from '@programcms/modal';

application.register('toolbar', class extends Controller {

    connect() {}

    buttonClick(event) {
        let button = event.currentTarget;
        let btnType = $(button).data('btn-type');
        let action = $(button).data('btn-action');
        let confirm = $(button).data('btn-confirm');

        if(confirm) {
            const modalOptions = {
                content: confirm.text === '' ? 'Do you really want to confirm this action ?' : confirm.text,
                buttons: [
                    {
                        text: 'Yes',
                        class: 'btn-primary',
                        click: function() {
                            window.location.href = action;
                        }
                    },
                    {
                        text: 'No',
                        class: 'btn-light',
                        dismiss: true
                    }
                ]
            }
            Modal.open('confirm', modalOptions);
            return;
        }

        if(btnType === 'save') {
            let btnTarget = $(button).data('btn-target');
            $('form#' + btnTarget).trigger('submit');
        }else{
            window.location = action;
        }
    }
});