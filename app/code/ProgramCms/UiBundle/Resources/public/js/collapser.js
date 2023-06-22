/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */
$(function(){
    $('.collapser a').click(function(e) {
        e.preventDefault();

        if(!$(this).hasClass('open')) {
            $(this).addClass('open');
        }else{
            $(this).removeClass('open');
        }
    });
});