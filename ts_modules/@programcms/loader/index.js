/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

/**
 * Ajax Loader Class
 */
class Loader {
    /**
     * Start Loader
     */
    static startLoader() {
        this.initOverlay();
        $("body").addClass("loading");
    }

    /**
     * Stop Loader
     */
    static stopLoader() {
        $("body").removeClass("loading");
    }

    /**
     * Init Overlay if dont exists in the DOM
     */
    static initOverlay() {
        if($('body .overlay').length === 0) {
            $('<div>', {
                id: 'overlay',
                class: 'overlay',
            }).appendTo('body');
        }
    }
}

module.exports = Loader;