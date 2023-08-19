/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    connect() {
        $(function() {
            $('.config-menu ul li.root').click(function(e) {
                e.preventDefault();

                if(!$(this).hasClass('open')) {
                    $(this).addClass('open');
                }else{
                    $(this).removeClass('open');
                }

                $(this).next().slideToggle('fast');
            });
        });
    }
}