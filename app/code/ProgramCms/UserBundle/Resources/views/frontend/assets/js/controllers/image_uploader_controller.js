/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('image-uploader', class extends Controller {

    static values = {
        preview: String,
        browse: String
    };

    connect() {

    }

    /**
     * Upload image & preview
     * @param event
     */
    uploadImage(event) {
        if (event.target.files.length > 0) {
            const src = URL.createObjectURL(event.target.files[0]);
            let preview = $(this.previewValue);
            preview.css({'background-image': 'url(' + src + ')'});

            // Upload image
            var file_data = $('#browse-photo').prop('files')[0];
            var form_data = new FormData();
            form_data.append('profile_photo', file_data);
            $.ajax({
                url: $('#send_photo_form').attr('action'),
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: form_data,
                success: function(response) {

                }
            });
        }
    }

    /**
     * Trigger image browse window
     */
    triggerBrowse() {
        $(this.browseValue).trigger('click');
    }
});