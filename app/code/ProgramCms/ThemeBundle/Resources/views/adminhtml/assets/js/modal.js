/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

export class Modal {
    constructor(selector) {
        this.selector = selector;
    }

    open() {
        alert('open');
    }
}

module.exports = Modal;