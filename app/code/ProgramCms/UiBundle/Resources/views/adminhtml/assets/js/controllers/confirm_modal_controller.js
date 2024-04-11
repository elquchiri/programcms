/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import Modal from '@programcms/modal';

application.register('confirm-modal', class extends Controller {

    static values = {
        message: String,
    };

    connect() {

    }

    /**
     * Confirm action modal
     */
    confirm() {
        const url = $(this.element).attr('href');
        const modalOptions = {
            content: !empty(this.messageValue) ? this.messageValue : 'Do you really want to confirm this action ?',
            buttons: [
                {
                    text: 'Yes',
                    class: 'btn-primary',
                    click: function() {
                        window.location.href = url;
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
    }
});