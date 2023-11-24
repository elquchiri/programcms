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

    connect() {}

    inheritCheckboxClick(event) {
        event.preventDefault();
        let currentCheckboxInherit = event.currentTarget;
        let inheritId = $(currentCheckboxInherit).attr('id');
        let fieldId = inheritId.replace(/_inherit$/, '');

        if($(currentCheckboxInherit).prop('checked')) {
            $('#' + fieldId).attr('disabled', true);
        }else{
            $('#' + fieldId).attr('disabled', false);
        }
    }
}