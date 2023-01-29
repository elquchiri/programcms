$(function() {
    $('.config-menu ul li.root').click(function(e) {
        e.preventDefault();

        $(this).next().toggle();
    })
});