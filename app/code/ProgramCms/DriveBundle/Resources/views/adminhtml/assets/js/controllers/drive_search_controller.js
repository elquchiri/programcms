/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('drive-search', class extends Controller {

    connect() {
        let self = this;
        $('#drive_search').on('keyup', function(e) {
            e.preventDefault();
            const qWord = $(this).val();
            self.doSearch(qWord);
        });
    }

    doSearch(qWord) {
        let self = this;
        $.ajax({
            url: '/admin/drive/ajax/search',
            type: 'POST',
            data: {'drive_search': qWord},
            success: function(response) {
                if(response['success']) {
                    $('.file_manager').html("");
                    const resultData = response['data'];
                    for(let i=0; i<resultData.length; i++) {
                        const file = resultData[i];
                        const fileId = file['id'];
                        const fileIcon = self.getFileTypeIcon(file);
                        $('.file_manager').prepend(
                            "<div class=\"file_item_container col-2 mb-3 ps-2 pe-2\">" +
                            "<div class=\"card h-100 file_item\" id=\""+ fileId +"\">" +
                            "<div class=\"card-body\">" +
                            "<p>" +
                            "<img alt=\"\" src=\""+ fileIcon +"\" width=\"48\" height=\"48\">" +
                            "</p>" +
                            "<a href=\""+ file['path'] +"\" target=\"_blank\" class=\"file_name\">"+ file['name'] +"</a>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                        );
                    }
                }
            },
            xhr: function() {
                const xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function(event) {
                    if (event.lengthComputable) {
                        let percent = (event.loaded / event.total) * 100;
                    }
                }

                return xhr;
            }
        });
    }

    getFileTypeIcon(file) {
        const fileExtension = file['extension'];
        const extension = fileExtension.toLowerCase();
        switch(extension) {
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'webp':
            case 'svg':
                return file['path'];
            case 'pdf':
                return '/bundles/programcmsdrive/images/file_types/pdf.png';
            default:
                return '/bundles/programcmsdrive/images/file_types/file.png';
        }
    }
})