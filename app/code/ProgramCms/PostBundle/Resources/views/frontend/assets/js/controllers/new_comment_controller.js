/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import Loader from "@programcms/loader";

application.register('new-comment', class extends Controller {

    connect() {

    }

    onSubmit(event) {
        event.preventDefault();
        let form = $(this.element);
        let commentElement = $('textarea[name=comment]');
        let post = $('input[name=post_id]');
        $.ajax({
            url: form.attr('action'),
            method: 'post',
            data: {
                'comment': commentElement.val(),
                'post_id': post.val(),
            },
            beforeSend: function () {
                Loader.startLoader();
            },
            success: function (response) {
                let comment = response.data.comment;
                let user = response.data.user;
                commentElement.val('');
                $('#comment-container').before(
                    "<tr>\n" +
                    "                        <td>\n" +
                    "                            <ul class=\"list-group list-group-flush\">\n" +
                    "                                <li class=\"list-group-item text-center\">\n" +
                    "                                    <div class=\"profile-image\"\n" +
                    "                                         style=\"display: inline-block; border: 3px solid #6d9dcb; width: 38px; height: 38px; border-radius: 50%; padding: 1px;\">\n" +
                    "                                        <img src=\""+ user.image +"\"\n" +
                    "                                             style=\"width: 100%; height: 100%; border-radius: 50%;\" alt=\"\"/>\n" +
                    "                                    </div>\n" +
                    "                                    <p class=\"m-0 mt-2\">"+ user.fullname +"</p>\n" +
                    "                                    <p class=\"text-muted m-0\" style=\"font-size: 13px;\">مدير المنتديات</p>\n" +
                    "                                </li>\n" +
                    "                            </ul>\n" +
                    "                        </td>\n" +
                    "                        <td>"+ comment +"</td>\n" +
                    "                    </tr>"
                )
            },
            complete: function () {
                Loader.stopLoader();
            }
        });
    }
})