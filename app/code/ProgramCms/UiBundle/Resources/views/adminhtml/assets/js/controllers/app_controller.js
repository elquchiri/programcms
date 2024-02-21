/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

/**
 * App Ui Controller
 */
application.register('app', class extends Controller {
    static values = {
        component: String
    }

    /**
     * Runs Anytime the controller is connected to the DOM
     */
    connect() {
        this.render();
    }

    /**
     * Load and render component
     */
    render() {
        const base_url = window.location.origin;

        $.ajax({
            url: base_url + 'ui/index/render',
            type: 'get',
            data: {
                'component': this.componentValue
            },
            success: function(response) {
                this.element.innerHTML = response;
                this.application.load();
            }
        });
    }
});