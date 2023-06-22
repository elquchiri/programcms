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