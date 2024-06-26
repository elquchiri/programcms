/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('tabs', class extends Controller {

    connect() {
        $('.collapser').hide().first().show();
    }

    tabClick(event) {
        event.preventDefault();

        let tabLink = event.currentTarget;
        let id = $(tabLink).attr('id');

        $('.tabs-menu ul li a').removeClass('active');
        $(tabLink).addClass('active');

        // Collapser
        $('.collapser').hide();
        $('#collapser-' + id).show();
    }
});