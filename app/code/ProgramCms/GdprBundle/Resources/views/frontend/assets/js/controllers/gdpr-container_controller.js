/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Controller } from '@hotwired/stimulus';

/**
 * Sidebar Controller
 * Manage Backoffice entries and pages
 */
application.register('gdpr-container', class extends Controller {
    /**
     * Cookie name
     * @type {string}
     */
    static gdpr_cookie_name = 'gdpr_cookie';

    /**
     * Check GDPR cookie existence
     */
    connect() {
        if(this.getCookie(this.constructor.gdpr_cookie_name) === '') {
            // The GDPR cookie dont exists (not approved by user yet)
            $(this.element).show();
        }
    }

    gdprApproveClick(event) {
        event.preventDefault();
        $(this.element).fadeOut();
        this.setCookie(this.constructor.gdpr_cookie_name, 1, 30);
    }

    setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
});