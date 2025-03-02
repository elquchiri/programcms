/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('tabs', class extends Controller {

    connect() {
        $('.collapser').hide();

        if (window.location.hash) {
            let hash = window.location.hash;
            const colapserId = hash.replace('#', '');

            $('.tabs-menu ul li a').removeClass('active');
            $('#' + colapserId).addClass('active');
            // Activate the corresponding tab
            $('#collapser-' + colapserId).show();
        }else{
            $('.collapser').first().show();
        }
    }

    tabClick(event) {
        let tabLink = event.currentTarget;
        let id = $(tabLink).attr('id');

        $('.tabs-menu ul li a').removeClass('active');
        $(tabLink).addClass('active');

        // Collapser
        $('.collapser').hide();
        $('#collapser-' + id).show();
    }
});