/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import Coloris from "@melloware/coloris";

application.register('color', class extends Controller {

    connect() {
        const elementId = $(this.element).attr('id');
        Coloris.init();
        Coloris({
            el: "#" + elementId,
            theme: 'pill',
            themeMode: 'dark',
            formatToggle: true,
            closeButton: true,
            clearButton: true,
            swatches: [
                '#067bc2',
                '#84bcda',
                '#80e377',
                '#ecc30b',
                '#f37748',
                '#d56062'
            ]
        });
    }
});