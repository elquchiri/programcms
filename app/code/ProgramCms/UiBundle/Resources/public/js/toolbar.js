/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */
$(function() {
    $('.ef-toolbar-btn').click(function(e) {
        let btnType = $(this).data('ef-btn-type');
        let action = $(this).data('ef-btn-action');

        if(btnType == 'save') {
            let btnTarget = $(this).data('ef-btn-target');

            $('form#' + btnTarget)
                .attr('action', action)
                .attr('method', 'POST')
                .submit();
        }
    });
});