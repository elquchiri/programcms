/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import { Datepicker } from 'vanillajs-datepicker';

application.register('date', class extends Controller {

    connect() {
        const datepicker = new Datepicker(this.element, {
            autoHide: false
        });
    }
});