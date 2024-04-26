/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import Modal from '@programcms/modal';

application.register('image-uploader', class extends Controller {

    static values = {
        preview: String,
        browse: String
    };

    connect() {

    }

    /**
     * Show image preview
     * @param event
     */
    showPreview(event) {
        if (event.target.files.length > 0) {
            const src = URL.createObjectURL(event.target.files[0]);
            let preview = $('#' + this.previewValue);
            preview.css({'background-image': 'url(' + src + ')'});
        }
    }

    /**
     * Trigger image browse window
     */
    triggerBrowse() {
        $(this.browseValue).trigger('click');
    }

    /**
     * Open Media Browser
     */
    openMediaBrowser() {
        const modalOptions = {
            content: 'Do you really want to confirm this action ?',
            buttons: [
                {
                    text: 'Yes',
                    class: 'btn-primary',
                    click: function() {
                        alert('clicked');
                    }
                },
                {
                    text: 'No',
                    class: 'btn-light',
                    dismiss: true
                }
            ]
        }
        Modal.open('modal', modalOptions);
    }
});