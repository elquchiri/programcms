/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    connect() {}

    buttonClick(event) {
        let button = event.currentTarget;
        let btnType = $(button).data('btn-type');
        let action = $(button).data('btn-action');
        let confirm = $(button).data('btn-confirm');

        if(confirm !== '') {
            $('.confirm-modal').modal('show');
            return;
        }

        if(btnType === 'save') {
            let btnTarget = $(button).data('btn-target');

            $('form#' + btnTarget)
                .attr('action', action)
                .attr('method', 'POST')
                .submit();
        }else{
            window.location = action;
        }
    }
}