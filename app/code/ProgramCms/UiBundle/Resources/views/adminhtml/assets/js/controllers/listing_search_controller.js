/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('listing-search', class extends Controller {

    connect() {

    }

    onSubmit(event) {
        event.preventDefault();
        let currentHash = window.location.hash;
        let form = this.element;
        form.action = window.location.pathname + window.location.search + currentHash;
        form.submit();
    }
});