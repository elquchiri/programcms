/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('editor', class extends Controller {
    /**
     * @type {{placeholder: StringConstructor}}
     */
    static values = {
        placeholder: String,
    };

    connect() {

    }
});