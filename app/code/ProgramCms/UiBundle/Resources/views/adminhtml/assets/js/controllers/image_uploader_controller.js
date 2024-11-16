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
        browse: String,
        target: String
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
        const self = this;
        let modalContent = "<div class=\"file_manager row mt-1 mb-5\" data-controller=\"file-manager\">\n" +
            "<p class=\"ps-3 text-muted loader_container\">\n" +
            "    <small>\n" +
            "        Loading from PDrive ...\n" +
            "    </small>\n" +
            "</p>\n" +
            "</div>\n" +
            "<div class=\"file_manager_dragover\"></div>";

        const modalOptions = {
            id: 'drive-image',
            size: 'modal-xl',
            scrollable: 'modal-dialog-scrollable',
            title: 'P-Drive Gallery',
            content: modalContent,
            buttons: [
                {
                    text: 'Select',
                    class: 'btn-primary',
                    click: function() {
                        const activeFile = $('.file_item.active');
                        const selectedImage = activeFile.find('img').attr('src');

                        $('#img-' + self.targetValue).css({'background-image': 'url(' + selectedImage + ')'});
                        $('#drive-image').modal('hide');

                        let targetSelector = $('#' + self.targetValue);
                        const targetSelectorName = targetSelector.attr('name');
                        let fileInput = targetSelector.clone();
                        let parentInput = targetSelector.parent();
                        let newFileInput = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', targetSelectorName)
                            .attr('id', self.targetValue)
                            .attr('value', selectedImage);
                        targetSelector.remove();
                        $(parentInput).append(newFileInput);

                    }
                },
                {
                    text: 'Close',
                    class: 'btn-light',
                    dismiss: true
                }
            ]
        }

        // Open Modal
        Modal.open('modal', modalOptions);
    }
});