/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

class User {
    /**
     * Flash messages container
     * @type {string}
     */
    static MESSAGE_WRAPPER_CLASS = '.flashes-wrapper';

    /**
     * Add Flash Message to the page
     * @param type
     * @param message
     */
    static addFlash(type, message) {
        $(this.MESSAGE_WRAPPER_CLASS).append(
            "<div class=\"alert flash-message alert-" + type + " flash-message-"+ type + "\" role=\"alert\">" +
                message +
            "</div>"
        );
        return this;
    }

    /**
     * Clear all flash messages
     */
    static clearFlashes() {
        $(this.MESSAGE_WRAPPER_CLASS).html('');
        return this;
    }

    /**
     * Scroll Top
     */
    static scrollTop() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return this;
    }
}

module.exports = User;