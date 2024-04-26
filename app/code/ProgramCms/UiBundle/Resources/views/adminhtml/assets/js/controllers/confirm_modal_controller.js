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
        title: String,
        message: String,
        yes: String,
        no: String
    };

    connect() {

    }

    /**
     * Confirm action modal
     */
    confirm() {
        const url = $(this.element).attr('href');
        const modalOptions = {
            title: this.titleValue ?? 'Confirmation',
            content: this.messageValue ?? 'Do you really want to confirm this action ?',
            buttons: [
                {
                    text: this.yesValue ?? 'Yes',
                    class: 'btn-primary',
                    click: function() {
                        window.location.href = url;
                    }
                },
                {
                    text: this.noValue ?? 'No',
                    class: 'btn-light',
                    dismiss: true
                }
            ]
        }
        Modal.open('confirm', modalOptions);
    }
});