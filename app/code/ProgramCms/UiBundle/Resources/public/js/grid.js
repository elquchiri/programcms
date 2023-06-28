/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */
$(function(){
    var display = false;

    $('#filters-tab').click(function(e){
        e.preventDefault();
        if(!display) {
            $('.grid-filters-tabs').addClass('open');
            display = true;
        }else{
            $('.grid-filters-tabs').removeClass('open');
            $(this).removeClass('active').removeClass('open');
            $('#filters').removeClass('active').removeClass('show');
            display = false;
        }
    });
});