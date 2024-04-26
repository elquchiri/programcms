/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Application } from 'stimulus';

// Initialize the Stimulus application
window.application = Application.start();

import $ from 'jquery';
import 'bootstrap';
import {Tooltip} from 'bootstrap';

window.$ = window.jQuery = $;

// Activate Tooltips
$(function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl)
    });
});