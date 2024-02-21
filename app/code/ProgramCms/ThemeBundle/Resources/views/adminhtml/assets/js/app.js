/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Application } from 'stimulus';

// Initialize the Stimulus application
window.application = Application.start();

import './app.scss';
import $ from 'jquery';
import 'bootstrap';

window.$ = window.jQuery = $;