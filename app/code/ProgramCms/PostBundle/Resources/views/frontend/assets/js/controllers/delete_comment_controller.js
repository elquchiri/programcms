/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import Loader from "@programcms/loader";

application.register('delete-comment', class extends Controller {

    connect() {

    }

    onDelete(event) {
        event.preventDefault();
        const base_url = window.location.origin;
        let element = $(this.element);
        let commentId = element.attr('id');
        $.ajax({
            url: base_url + '/post/comment/delete',
            method: 'post',
            data: {
                'comment_id': commentId
            },
            beforeSend: function () {
                Loader.startLoader();
            },
            success: function (response) {
                if(response.success) {
                    $('#comment-' + response.data.commentId).remove();
                }
            },
            complete: function () {
                Loader.stopLoader();
            }
        });
    }
})