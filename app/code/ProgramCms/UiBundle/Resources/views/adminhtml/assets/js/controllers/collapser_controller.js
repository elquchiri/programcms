/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

/**
 * Collapser Ui Controller
 */
export default class extends Controller {

    connect() {

    }

    collapserClick(event) {
        event.preventDefault();
        let collapserLink = event.currentTarget;

        if(!$(collapserLink).hasClass('open')) {
            $(collapserLink).addClass('open');
        }else{
            $(collapserLink).removeClass('open');
        }
    }
}