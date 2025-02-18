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

        $('.export_listing li a').on('click', function(e) {
            e.preventDefault();

            let filters = {};
            let searchValue = $('input[name=keyword_search]').val();
            const baseUrl = window.location.origin;

            $('#filters form')
                .find(':input:not(:hidden)')
                .serializeArray()
                .forEach(function(item) {
                    if (item.value !== '') {
                        let cleanName = item.name.replace(/_filter$/, ''); // Remove '_filter' from the name
                        filters[`filters[${cleanName}]`] = item.value; // Properly format for PHP
                    }
                });

            // Convert object to URL parameters
            let url = new URL(window.location.href);
            let path = url.pathname;
            let formattedPath = path.substring(1).replace(/\//g, '_').replace('admin_', '');
            const uri = '?'
                + $.param(filters)
                + '&search=' + encodeURIComponent(searchValue)
                + '&layout=' + formattedPath;

            window.location.href = baseUrl + '/admin/ui/export/csv' + uri;
        });
    }
});