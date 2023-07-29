/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    connect() {
        this._updateSwitcher(this.element);
    }

    switcherClick(event) {
        let switcher = event.currentTarget;
        this._updateSwitcher(switcher);
    }

    /**
     * Update Switcher Field
     * @private
     */
    _updateSwitcher(switcher) {
        let statusLabel = $(switcher).find('label.status');
        let checkbox = $(switcher).find('input[role=switch]');
        if(checkbox.prop('checked')) {
            statusLabel.removeClass('status-no').addClass('status-yes').html('Yes');
        }else{
            statusLabel.removeClass('status-yes').addClass('status-no').html('No');
        }
    }
}