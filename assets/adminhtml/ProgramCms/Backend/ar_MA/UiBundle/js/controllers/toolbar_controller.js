/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

import modal from './../../../ThemeBundle/js/modal';

export default class Toolbar extends Controller {

    connect() {}

    buttonClick(event) {
        let button = event.currentTarget;
        let btnType = $(button).data('btn-type');

        if(btnType === 'save') {
            let confirm = $(button).data('btn-confirm');

            if(confirm !== '') {
                new modal().open();
                $('.confirm-modal').modal('show');
                return;
            }

            let btnTarget = $(button).data('btn-target');
            $('form#' + btnTarget)
                .attr('method', 'POST')
                .submit();
        }else{
            let action = $(button).data('btn-action');
            window.location = action;
        }
    }
}

export { Toolbar }