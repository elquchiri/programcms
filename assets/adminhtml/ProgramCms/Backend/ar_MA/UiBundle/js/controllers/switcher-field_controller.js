/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

export default class SwitcherField extends Controller {
    /**
     * @type {{no: {default: string, type: StringConstructor}, yes: {default: string, type: StringConstructor}}}
     */
    static values = {
        yes: { type: String, default: 'Yes' },
        no: { type: String, default: 'No' },
    }

    connect() {
        this._updateSwitcher(this.element);
    }

    /**
     * @param event
     */
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
            statusLabel.removeClass('status-no').addClass('status-yes').html(this.yesValue);
        }else{
            statusLabel.removeClass('status-yes').addClass('status-no').html(this.noValue);
        }
    }
}

export { SwitcherField }