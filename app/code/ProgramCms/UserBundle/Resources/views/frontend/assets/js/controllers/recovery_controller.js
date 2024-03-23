/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Controller } from '@hotwired/stimulus';
import Loader from '@programcms/loader';
import User from '@programcms/user';

/**
 * Recovery Controller
 */
application.register('recovery', class extends Controller {
    /**
     * Current Step
     * @type {number}
     */
    static step = 0;

    connect() {

    }

    /**
     * Verify & Process Steps
     * @param event
     */
    verifyStep(event) {
        event.preventDefault();
        const baseUrl = window.location.origin;
        switch(this.constructor.step) {
            case 0:
                this.verifyUser(baseUrl);
                break;
            case 1:
                this.verifyToken(baseUrl);
                break;
            case 2:
                this.updatePassword(baseUrl);
                break;
        }
    }

    verifyUser(baseUrl) {
        let email = $('#email').val();
        let $this = this;
        $.ajax({
            url: baseUrl + '/user/recovery/verifyuser',
            type: 'post',
            data: {
                'email': email
            },
            beforeSend: function() {
                Loader.startLoader();
            },
            success: function(response) {
                User.clearFlashes();

                switch(response.success) {
                    case false:
                        User.addFlash('danger', response.message).scrollTop();
                        break;
                    case true:
                        $this.constructor.step = 1;
                        $('.recovery_email').addClass('opacity-25');
                        $('#email').attr('disabled', true);
                        $('.user_token').removeClass('opacity-25');
                        $('#user_token').attr('disabled', false);
                        User.addFlash('success', response.message).scrollTop();
                        break;
                }
            },
            complete: function() {
                Loader.stopLoader();
            }
        });
    }

    verifyToken(baseUrl) {
        let token = $('#user_token').val();
        let $this = this;
        $.ajax({
            url: baseUrl + '/user/recovery/verifytoken',
            type: 'post',
            data: {
                'token': token
            },
            beforeSend: function() {
                Loader.startLoader();
            },
            success: function(response) {
                User.clearFlashes();

                switch(response.success) {
                    case false:
                        User.addFlash('danger', response.message).scrollTop();
                        break;
                    case true:
                        $this.constructor.step = 2;
                        $('.user_token').addClass('opacity-25');
                        $('#user_token').attr('disabled', true);
                        $('.password_container').removeClass('opacity-25');
                        $('#password').attr('disabled', false);
                        $('#check_password').attr('disabled', false);
                        User.addFlash('success', response.message).scrollTop();
                        break;
                }
            },
            complete: function() {
                Loader.stopLoader();
            }
        });
    }

    updatePassword(baseUrl) {
        let token = $('#user_token').val();
        let password = $('#password').val();
        let checkPassword = $('#check_password').val();
        $.ajax({
            url: baseUrl + '/user/recovery/updatepassword',
            type: 'post',
            data: {
                'token': token,
                'password': password,
                'check_password': checkPassword
            },
            beforeSend: function() {
                Loader.startLoader();
            },
            success: function(response) {
                User.clearFlashes();

                switch(response.success) {
                    case false:
                        User.addFlash('danger', response.message).scrollTop();
                        Loader.stopLoader();
                        break;
                    case true:
                        window.location.href = baseUrl + '/user/account/login'
                        break;
                }
            }
        });
    }
});