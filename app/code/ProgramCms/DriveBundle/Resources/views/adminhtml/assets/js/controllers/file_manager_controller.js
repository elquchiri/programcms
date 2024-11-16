/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('file-manager', class extends Controller {

    connect() {
        let self = this;
        let isDragging = false;

        self.loadFiles();

        $(document)
            .on('dragover', 'body', function(event) {
                event.preventDefault();
                event.originalEvent.dataTransfer.dropEffect = 'copy'; // Necessary for some browsers
                if (!isDragging) {
                    isDragging = true;
                    self.triggerDragOver();
                }
            })
            .on('dragleave', 'body', function(e) {
                e.preventDefault();
                // Check if the related target is still within the body
                if (!e.relatedTarget || !$.contains(document.body, e.relatedTarget)) {
                    isDragging = false;
                    self.triggerDrop();
                }
            })
            .on('drop', 'body', function(e) {
                e.preventDefault();
                isDragging = false;
                self.triggerDrop();

                const files = e.originalEvent.dataTransfer.files; // Get the dropped files
                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const formData = new FormData();
                        let progressId = self.getRandomIntInclusive(1, 9999999);
                        formData.append('file', file, file.name);
                        self.appendFile(file, progressId);
                        self.uploadFile(formData, progressId);
                    }
                }
            });

        // File Viewer
        $(document).on('click', '.file_item', function(e) {
            e.preventDefault();
            $('.file_item').removeClass('active');
            $(this).addClass('active');
            let fileId = $(this).attr('id');
            self.getFile(fileId);
            $('.drive_previewer').html("<img src=\"" + $(this).find('img').attr('src') + "\" style=\"max-width: 100%;\">");
        });
    }

    appendFile(file, progressId) {
        const self = this;
        const filename = file.name;
        const fileExtension = filename.split('.').pop();
        let fileIcon = this.getFileTypeIcon(fileExtension, '');
        if(this.isImage(fileExtension)) {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                // convert image file to base64 string
                $('#file_item_' + progressId).find('img').attr('src', reader.result);
                fileIcon = reader.result;
            }, false);
            if (file) {
                reader.readAsDataURL(file);
            }
        }

        $('.file_manager').prepend(
            "<div class=\"file_item_container col-2 mb-3 ps-2 pe-2\" id=\"file_item_"+ progressId +"\">" +
            "<div class=\"card h-100 file_item disabled\" id=\"\">" +
            "<div class=\"card-body\">" +
            "<p>" +
                "<img alt=\"\" src=\""+ fileIcon +"\" width=\"48\" height=\"48\">" +
            "</p>" +
            "<a href=\"#\" class=\"file_name\" id=\"file_name_"+ progressId +"\" target=\"_blank\">"+ self.shortenString(filename, 21) +"</a>" +
            "</div>" +
            "<div class=\"progress\">" +
            "   <div class=\"progress-bar\" id=\"progress-bar-" + progressId + "\" role=\"progressbar\" style=\"width: 0%\" aria-valuenow=\"0\" aria-valuemin=\"0\" aria-valuemax=\"100\">0%</div>" +
            "</div>" +
            "</div>" +
            "</div>"
        );
    }

    triggerDragOver() {
        $('.file_manager_dragover').show();
    }

    triggerDrop() {
        $('.file_manager_dragover').hide();
    }

    /**
     * Upload File
     * @param formData
     * @param progressId
     */
    uploadFile(formData, progressId) {
        $.ajax({
            url: '/admin/drive/upload/file',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response['success']) {
                    const file = response['file'];
                    $('#file_item_' + progressId).find('.file_item').attr('id', file['id']);
                    $('#file_name_' + progressId).attr('href', file['path']);
                }
            },
            xhr: function() {
                const xhr = $.ajaxSettings.xhr();
                // File Upload Progression
                xhr.upload.onprogress = function(event) {
                    if (event.lengthComputable) {
                        let percent = (event.loaded / event.total) * 100;
                        let progress = $('#progress-bar-' + progressId);
                        progress.css('width', percent + '%'); // Update width
                        progress.text(Math.floor(percent) + '%'); // Update text to show percentage
                        progress.attr('aria-valuenow', percent);
                        if(percent === 100) {
                            progress.parent().remove();
                        }
                        $('#file_item_' + progressId).find('.file_item').removeClass('disabled');
                    }
                }

                return xhr;
            }
        });
    }

    getRandomIntInclusive(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    loadFiles() {
        let self = this;
        $.ajax({
            url: '/admin/drive/ajax/index',
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {
                $('.loader_container').remove();
                for(let i=0; i<response.length; i++) {
                    const file = response[i];
                    const fileId = file['id'];
                    const fileIcon = self.getFileTypeIcon(file['extension'], file['path']);
                    const filePath = file['path'];
                    $('.file_manager').prepend(
                        "<div class=\"file_item_container col-2 mb-3 ps-2 pe-2\">" +
                        "<div class=\"card h-100 file_item\" id=\""+ fileId +"\" data-file-path=\""+ filePath +"\">" +
                        "<div class=\"card-body\">" +
                        "<p>" +
                        "<img alt=\"\" src=\""+ fileIcon +"\" width=\"68\" height=\"68\">" +
                        "</p>" +
                        "<a href=\""+ file['path'] +"\" target=\"_blank\" class=\"file_name\">"+ self.shortenString(file['name'], 17) +"</a>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );
                }
            }
        });
    }

    getFileTypeIcon(extension, filePath) {
        extension = extension.toLowerCase();
        switch(extension) {
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'webp':
            case 'svg':
                return filePath;
            case 'mkv':
                return '/bundles/programcmsdrive/images/file_types/video.png';
            case 'pdf':
                return '/bundles/programcmsdrive/images/file_types/pdf.png';
            default:
                return '/bundles/programcmsdrive/images/file_types/file.png';
        }
    }

    getFile(fileId) {
        let self = this;
        $.ajax({
            url: '/admin/drive/ajax/file',
            type: 'POST',
            data: {id: fileId},
            success: function(response) {
                if(response['success']) {
                    let file = response['file'];
                    $('#drive_viewer_filename').html(self.shortenString(file['name'], 19));
                    $('#drive_viewer_extension').html(file['extension']);
                    $('#drive_viewer_size').html(file['size']);
                    $('#drive_viewer_created_at').html(file['created_at']);
                    $('#drive_viewer_updated_at').html(file['updated_at']);
                    self.setPerms(file['perms']);
                }
            }
        });
    }

    shortenString(str, maxLength) {
        if (str.length <= maxLength) {
            return str;
        }
        return str.slice(0, maxLength - 3) + '...';
    }

    setPerms(perms) {

    }

    isImage(extension) {
        return extension === 'png' || extension === 'jpg' || extension === 'jpeg' || extension === 'gif' || extension === 'webp' || extension === 'svg';
    }
});