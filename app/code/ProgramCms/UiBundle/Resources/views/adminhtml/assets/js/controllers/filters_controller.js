/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import { Tab } from "bootstrap";

application.register('filters', class extends Controller {
    static values = {
        status: 0
    }

    connect() {
        let display = false;

        $('#filters-tab').on('click', function (e) {
            e.preventDefault();
            if (!display) {
                $('.grid-filters-tabs').addClass('open');
                display = true;
            } else {
                $('.grid-filters-tabs').removeClass('open');
                $(this).removeClass('active').removeClass('open');
                $('#filters').removeClass('active').removeClass('show');
                display = false;
            }
        });

        if (this.statusValue === 1) {
            $('#filters-tab').trigger('click');
            const filtersTab = document.querySelector('#filters-tab');
            const tab = new Tab(filtersTab);
            tab.show();
        }
    }
});