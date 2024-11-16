/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

const Modal = require('@programcms/modal');

/**
 * Drive Class
 */
class Drive {

    /**
     * Container name
     * @type {string}
     */
    static container = '';

    static editor = null;

    static isDragging = false;

    static init(config) {
        this.container = config.container;
        this.editor = config.editor;
    }

    /**
     * Open Drive modal
     */
    static openDialog() {
        const self = this;
        const modalContent = "<div class=\"file_manager row mt-1 mb-5\">\n" +
            "<p class=\"ps-3 text-muted loader_container\">\n" +
            "    <small>\n" +
            "        Loading from PDrive ...\n" +
            "    </small>\n" +
            "</p>\n" +
            "</div>\n" +
            "<div class=\"file_manager_dragover\"></div>";

        const modalOptions = {
            id: this.container,
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
                        const selectedFile = activeFile.data('file-path');
                        const selectedFileName = activeFile.data('file-name');
                        const selectedFileSize = activeFile.data('file-size');
                        $('#' + self.container).trigger('pcms:drive:file:selected', [selectedFile, selectedFileName, selectedFileSize]);
                        self.closeDialog();
                    }
                },
                {
                    text: 'Close',
                    class: 'btn-light',
                    // dismiss: true
                    click: function() {
                        self.closeDialog();
                    }
                }
            ]
        }

        // Open Modal
        Modal.open('modal', modalOptions);

        $('#' + this.container).on('hide.bs.modal', function(e) {
            $('#' + self.container).trigger('pcms:drive:closed');
        });

        // Load Files
        this.loadFiles();

        this.dragAndDrop();

        // File Selection
        this.selectFile();
    }

    /**
     * Load Files
     */
    static loadFiles() {
        const self = this;

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
                    const fileName = file['name'];
                    const fileSize = file['size'];
                    const fileIcon = self.getFileTypeIcon(file['extension'], file['path']);
                    const filePath = file['path'];
                    const fileType = file['mime']

                    if(self.editor) {
                        self.editor.AssetManager.add({
                            type: fileType,
                            src: filePath,
                            width: '500px',
                            height: '500px'
                        });
                    }

                    $('.file_manager').prepend(
                        "<div class=\"file_item_container col-2 mb-3 ps-2 pe-2\">" +
                        "<div class=\"card h-100 file_item\" id=\""+ fileId +"\" data-file-path=\""+ filePath +"\" data-file-name=\""+ fileName +"\" data-file-size=\""+ fileSize +"\">" +
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

    /**
     * Get File Icon
     * @param extension
     * @param filePath
     * @returns {string|*}
     */
    static getFileTypeIcon(extension, filePath) {
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

    static shortenString(str, maxLength) {
        if (str.length <= maxLength) {
            return str;
        }
        return str.slice(0, maxLength - 3) + '...';
    }

    static selectFile() {
        const self = this;
        $(document).on('click', '.file_item', function(e) {
            e.preventDefault();
            $('.file_item').removeClass('active');
            $(this).addClass('active');
            let fileId = $(this).attr('id');
            $('#' + self.container).trigger('pcms.drive.file.checked');
        });
    }

    static closeDialog() {
        $('#' + this.container)
            .modal('hide')
            .trigger('pcms:drive:closed');
    }

    static dragAndDrop() {
        const self = this;
        $(document)
            .on('dragover', 'body', function(event) {
                event.preventDefault();
                event.originalEvent.dataTransfer.dropEffect = 'copy'; // Necessary for some browsers
                if (!self.isDragging) {
                    self.isDragging = true;
                    self.triggerDragOver();
                }
            })
            .on('dragleave', 'body', function(e) {
                e.preventDefault();
                // Check if the related target is still within the body
                if (!e.relatedTarget || !$.contains(document.body, e.relatedTarget)) {
                    self.isDragging = false;
                    self.triggerDrop();
                }
            })
            .on('drop', 'body', function(e) {
                e.preventDefault();
                self.isDragging = false;
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
    }

    static triggerDrop() {
        $('.file_manager_dragover').hide();
    }

    static triggerDragOver() {
        $('.file_manager_dragover').show();
    }

    static getRandomIntInclusive(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    static appendFile(file, progressId) {
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

    static uploadFile(formData, progressId) {
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

    static isImage(extension) {
        return extension === 'png' || extension === 'jpg' || extension === 'jpeg' || extension === 'gif' || extension === 'webp' || extension === 'svg';
    }
}
module.exports = Drive;