/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

class Modal {
    /**
     * Default modal options
     * @type {{buttons: []}}
     */
    static options = {
        buttons: []
    };

    /**
     * Modal skin
     * @type {string}
     */
    static MODAL_SKIN = "<div class=\"modal fade\" id=\"${modal_id}\" tabindex=\"-1\">\n" +
        "  <div class=\"modal-dialog\">\n" +
        "    <div class=\"modal-content\">\n" +
        "      <div class=\"modal-header\">\n" +
        "        <h5 class=\"modal-title\"></h5>\n" +
        "        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n" +
        "      </div>\n" +
        "      <div class=\"modal-body\"></div>\n" +
        "      <div class=\"modal-footer\"></div>\n" +
        "    </div>\n" +
        "  </div>\n" +
        "</div>";

    /**
     * Init Modal
     * @param options
     * @returns {{content}|*}
     */
    static prepareOptions(options) {
        options.id = options.id ?? Date.now();
        options.title = options.title ?? '';
        options.skin = this.MODAL_SKIN.replace('${modal_id}', options.id);
        options.content = options.content ?? '';
        return options;
    }

    /**
     * Open new modal
     * @param type
     * @param options
     */
    static open(type, options) {
        options = this.prepareOptions(options);

        let modal = $(options.skin);
        // Remove modal from DOM when being completely hidden
        modal.on('hidden.bs.modal', function() {
            $(this).remove();
        });

        modal.find('.modal-title').html(options.title);
        modal.find('.modal-body').html(options.content);

        switch(type) {
            case 'confirm':
                this.confirm(modal, options.message);
                break;
        }

        // Append newly created modal to DOM
        modal.appendTo('body');

        this.processButtons(options);
        $('#' + options.id).modal('show');
    }

    /**
     * Confirm modal type
     * @param modal
     */
    static confirm(modal) {
        modal.find('.modal-dialog').addClass('modal-dialog-centered');
    }

    /**
     * Process buttons
     * @param options
     */
    static processButtons(options) {
        const buttons = options.buttons;
        for(let i=0; i<buttons.length; i++) {
            const button = buttons[i];
            const cssClass = button.class ?? 'btn-primary';
            let buttonElement = $('<button>')
                .addClass('btn ' + cssClass)
                .html(button.text).appendTo('.modal-footer');

            if(button.dismiss) {
                buttonElement.attr('data-bs-dismiss', 'modal');
            }

            if(button.click) {
                buttonElement.on('click', function() {
                    button.click();
                });
            }
        }
    }
}
module.exports = Modal;