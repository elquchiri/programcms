/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";

application.register('post-reaction', class extends Controller {
    static values = {
        post: String,
        type: String
    };

    static targets = ["reaction"];

    connect() {
        if(this.typeValue) {
            $('#' + this.typeValue).addClass('active');
        }
    }

    react(event) {
        const reactionElement = event.currentTarget;
        const reactionType = reactionElement.getAttribute('id');
        const postId = this.postValue;
        const reactionData = {
            'post_id': postId,
            'reaction_type': reactionType
        }

        this.ajaxCall(reactionData);

        if($(reactionElement).hasClass('active')) {
            $('.like-dislike-widget button').removeClass('active');
        }else{
            $('.like-dislike-widget button').removeClass('active');
            $(reactionElement).addClass('active');
        }

    }

    ajaxCall(reactionData) {
        const base_url = window.location.origin;
        $.ajax({
            url: base_url + '/post_reaction/ajax/react',
            type: 'post',
            data: reactionData,
            success: function(result) {

            }
        });
    }
});